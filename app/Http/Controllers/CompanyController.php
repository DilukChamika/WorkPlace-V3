<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Vacancy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function logout(){
        Auth::guard('company')->logout();
        return redirect('/login');
    }

    public function AddVacancy(Request $request){
        // dd($request->all());


        $request->validate([
            'jobfield'=>'required',
            'jobpost'=>'required',
            'salary'=>'required',
            'location'=>'required',
            'flyerimg'=>['required', 'image', 'mimes:jpg,png,jpeg', 'max:2048']
        ]);

        $vacancy = new Vacancy;
        $vacancy->jobField = $request->jobfield;
        $vacancy->jobPost = $request->jobpost;
        $vacancy->salary = $request->salary;
        $vacancy->location = $request->location;
        $vacancy->flyer =  $request->file('flyerimg')->store('FlyerImages','public');
        $vacancy->company_id = Auth::guard('company')->user()->id;

        $vacancy->save();
        return redirect('Company/home')->with('message', 'Vacancy Added Successfully!');

    }

    public function MyPosts(){
        $user = Auth::guard('company')->user(); // Retrieve the authenticated company user

        $vacancies = Vacancy::where('company_id', $user->id)->get();

        return view('Company.myposts', compact('vacancies'));
        
    }

    public function EditVacancy($vacancy_id){
        $vacancy = Vacancy::findOrFail($vacancy_id);

        // Perform any necessary logic and pass the vacancy to the edit_post view
        return view('Company.editpost', compact('vacancy'));
    }

    public function UpdateVacancy(Request $request, $vacancy_id){
        $vacancy = Vacancy::findOrFail($vacancy_id);
        if ($vacancy->company_id !== Auth::guard('company')->user()->id) {
            return back()->with('error', 'You are not authorized to update this vacancy.');
        }
        $request->validate([
            'jobfield'=>'required',
            'jobpost'=>'required',
            'salary'=>'required',
            'location'=>'required',
            'flyerimg'=>['required', 'image', 'mimes:jpg,png,jpeg', 'max:2048']
        ]);
        $vacancy->jobField = $request->jobfield;
        $vacancy->jobPost = $request->jobpost;
        $vacancy->salary = $request->salary;
        $vacancy->location = $request->location;
        $vacancy->flyer =  $request->file('flyerimg')->store('FlyerImages','public');

        $vacancy->save();
        return redirect('Company/home')->with('message', 'Vacancy Updated Successfully!');

    }

    public function DeleteVacancy($vacancy_id){
        $vacancy = Vacancy::findOrFail($vacancy_id);
        if ($vacancy->company_id !== Auth::guard('company')->user()->id) {
            return back()->with('error', 'You are not authorized to delete this vacancy.');
        }

        $filePath = 'storage/' . $vacancy->flyer;
        File::delete($filePath);

        $vacancy->delete();
        return redirect()->route('Company.myposts')->with('success', 'Vacancy deleted successfully.');
    }

    public function AboutMyCompany(){
        $user = Auth::guard('company')->user();
        return view('Company.AboutMe', compact('user'));
    }

    public function EditCompanyData(Request $request){
        $company = Auth::guard('company')->user();

        $this->validate($request,[
            'companyname' => 'required',
            'companyDescription' => 'required',
            'regnumber' => 'required',
            'email' => ['required', 'email'],
            'phone' => 'required',
            'Address' => 'required',
            'profilePicture' =>  ['required', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
            'comlinkedin' => 'required'
        ]);

        $filePath = 'storage/' . $company->profilePic;
        File::delete($filePath);

        $company->name = $request->companyname;
        $company->companyDescription = $request->companyDescription;
        $company->regNumber = $request->regnumber;
        $company->address = $request->Address;
        $company->email = $request->email;
        $company->tel = $request->phone;
        $company->linkedin = $request->comlinkedin;
        $company->profilePic = $request->file('profilePicture')->store('CompanyProfilePictures','public');

        $company->save();
        return redirect('Company/home')->with('message', 'Company Account Updated Successfully!');
    }
    
    public function DeleteMyAccount(){
        $user = Auth::guard('company')->user();
        $filePath = 'storage/' . $user->profilePic;
        File::delete($filePath);
        $user->delete();
        return redirect()->route('login')->with('success', 'Your account has been deleted.');
    }


}
