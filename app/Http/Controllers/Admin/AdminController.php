<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VendorsBusinessDetail;
use App\Models\VendorsBankDetail;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Vendor;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard(){
        return view("admin.dashboard");
    }

    public function updateAdminPassword(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password)){
                    if($data['confirm_password']==$data['new_password']){
                        Admin::where('id', Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['new_password'])]);
                        return redirect()->back()->with('success_message', 'Password has been updated successfully!');
                    }else{
                        return redirect()->back()->with('error_message', 'New Password and Confirm Password does not match!');
                    }
            }else{
                return redirect()->back()->with('error_message', 'Your current password is incorrect!');
            }
        }
        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        return view('admin.settings.update_admin_password')->with(compact('adminDetails'));
    }

    public function checkAdminPassword(Request $request){
        $data = $request->all();
        if(Hash::check($data['current_password'], Auth::guard('admin')->user()->password)){
            return "true";
        }else{
            return "false";
        }

    }

    public function updateAdminDetails(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'admin_name'=>'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile'=>'required|numeric'
            ];
            $customMessages = [
                'admin_name.required' => 'Name is required',
                'admin_name.regex' => 'Valid name is required',
                'admin_mobile.required'=> 'Mobile is required',
                'admin_mobile.numeric'=> 'Valid mobile is required'
            ];
            $this->validate($request, $rules,$customMessages);

            if ($request->hasFile('admin_image')) {
                $image_tmp = $request->file('admin_image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'admin/images/photo/' . $imageName;

                    // Move the file to the specified path
                    $image_tmp->move(public_path('admin/images/photo'), $imageName);
                }
            }
            Admin::where('id', Auth::guard('admin')->user()->id)->update(['name'=>$data['admin_name'],'mobile'=>$data['admin_mobile'], 'image'=>$imageName]);
            return redirect()->back()->with('success_message', 'Admin details updated successfully!');
        }
        return view('admin.settings.update_admin_details');
    }

    public function updateVendorDetails($slug, Request $request){
        if($slug=="personal"){
            if($request->isMethod('post')){
                $data = $request->all();
                if($request->isMethod('post')){
                    $data = $request->all();
                    $rules = [
                        'vendor_name'=>'required|regex:/^[\pL\s\-]+$/u',
                        'vendor_mobile'=>'required|numeric'
                    ];
                    $customMessages = [
                        'vendor_name.required' => 'Name is required',
                        'vendor_name.regex' => 'Valid name is required',
                        'vendor_mobile.required'=> 'Mobile is required',
                        'vendor_mobile.numeric'=> 'Valid mobile is required'
                    ];
                    $this->validate($request, $rules,$customMessages);

                    if ($request->hasFile('image')) {
                        $image_tmp = $request->file('image');
                        if ($image_tmp->isValid()) {
                            $extension = $image_tmp->getClientOriginalExtension();
                            $imageName = rand(111, 99999) . '.' . $extension;
                            $imagePath = 'admin/images/photo/' . $imageName;

                            // Move the file to the specified path
                            $image_tmp->move(public_path('admin/images/photo'), $imageName);
                        }
                    }else if(!empty($data['current_vendor_image'])){
                        $imageName = $data['current_vendor_image'];
                    }
                    else {
                        $imageName = ''; // Handle the case when there is no file uploaded
                    }
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['name'=>$data['vendor_name'],'mobile'=>$data['vendor_mobile'],  'image' => $imageName]);
                    Vendor::where('id', Auth::guard('admin')->user()->vendor_id)->update(['name'=>$data['vendor_name'],'mobile'=>$data['vendor_mobile'],'address'=>$data['vendor_address'],
                    'city'=>$data['vendor_city'],'state'=>$data['vendor_state'],'country'=>$data['vendor_country'],'pincode'=>$data['vendor_pincode']]);
                    return redirect()->back()->with('success_message', 'Vendor personal details updated successfully!');
                }
            }
            $vendorDetails = Vendor::where('id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();

        }else if($slug=="business"){
            if($request->isMethod('post')){
                $data = $request->all();
                if($request->isMethod('post')){
                    $data = $request->all();
                    $rules = [
                        'shop_name'=>'required|regex:/^[\pL\s\-]+$/u',
                        'shop_city'=>'required|regex:/^[\pL\s\-]+$/u',
                        'shop_mobile'=>'required|numeric',
                        'address_proof'=> 'required',


                    ];
                    $customMessages = [
                        'shop_name.required' => 'Name is required',
                        'shop_name.regex' => 'Valid name is required',
                        'shop_mobile.required'=> 'Mobile is required',
                        'shop_mobile.numeric'=> 'Valid mobile is required',
                        'address_proof.required'=> 'Valid Address Proof is required',
                        'address_proof_image.image'=> 'Valid Address Proof Image is required'
                    ];
                    $this->validate($request, $rules,$customMessages);

                    if ($request->hasFile('address_proof_image')) {
                        $image_tmp = $request->file('address_proof_image');
                        if ($image_tmp->isValid()) {
                            $extension = $image_tmp->getClientOriginalExtension();
                            $imageName = rand(111, 99999) . '.' . $extension;
                            $imagePath = 'admin/images/proofs/' . $imageName;

                            // Move the file to the specified path
                            $image_tmp->move(public_path('admin/images/proofs'), $imageName);
                        }
                    }else if(!empty($data['current_address_proof'])){
                        $imageName = $data['current_address_proof'];
                    }else {
                        $imageName = ''; // Handle the case when there is no file uploaded
                    }

                    VendorsBusinessDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->update(['shop_name'=>$data['shop_name'],'shop_mobile'=>$data['shop_mobile'],'shop_address'=>$data['shop_address'],
                    'shop_city'=>$data['shop_city'],'shop_state'=>$data['shop_state'],'shop_country'=>$data['shop_country'],'shop_pincode'=>$data['shop_pincode'],'business_license_number'=>$data['business_license_number'],'gst_number'=>$data['gst_number'],
                    'pan_number'=>$data['pan_number'], 'address_proof'=>$data['address_proof'], 'address_proof_image'=>$imageName
                ]);
                    return redirect()->back()->with('success_message', 'Vendor business details updated successfully!');
                }
            }
            $vendorDetails = VendorsBusinessDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();

        }else if($slug=="bank"){
            if($request->isMethod('post')){
                $data = $request->all();
                if($request->isMethod('post')){
                    $data = $request->all();
                    $rules = [
                        'account_holder_name'=>'required|regex:/^[\pL\s\-]+$/u',
                        'bank_name'=>'required',
                        'account_number'=>'required|numeric',
                        'bank_ifsc_code'=> 'required',


                    ];
                    $customMessages = [
                        'account_holder_name.required' => 'Account Holder Name is required',
                        'account_holder_name.regex' => 'Valid Account Holder Name is required',
                        'bank_name.required'=> 'Bank Name is required',
                        'account_number.required' => 'Account Number is required',
                        'account_number.numeric'=> 'Valid Account Number is required',
                        'bank_ifsc_code.required'=> 'Bank IFSC Code is required',

                    ];
                    $this->validate($request, $rules,$customMessages);


                    VendorsBankDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->update(['account_holder_name'=>$data['account_holder_name'],'bank_name'=>$data['bank_name'],
                    'account_number'=>$data['account_number'],'bank_ifsc_code'=>$data['bank_ifsc_code'],
                ]);
                    return redirect()->back()->with('success_message', 'Vendor bank details updated successfully!');
                }
            }
            $vendorDetails = VendorsBankDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();
        }
        return view('admin.settings.update_vendor_details')->with(compact('slug','vendorDetails'));
    }
    public function login(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();

            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ];

            $customMessages = [
                'email.required'=> 'Email Address is required',
                'email.email' => 'Valid Email Address is required',
                'password.required'=>'Password is required'
            ];

            $this->validate($request, $rules, $customMessages);

            if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password'], 'status'=>1])){
                return redirect('admin/dashboard');
            }else{
                return redirect()->back()->with('error_message', 'Invalid User or Password');
            }
        }

        return view("admin.login");
    }
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
}
