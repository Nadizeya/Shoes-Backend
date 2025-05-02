<?php

namespace App\Http\Controllers\admin\account;


use App\Models\Bank;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function index()
    {
        // $brands = Brand::all();
        // $brands = Brand::orderBy('id', 'desc')->get();
        $accounts = Account::with('bank')->latest()->get();
        return view('account.index', compact('accounts'));
    }

    public function create()
    {
        $banks = Bank::all();
        return view('account.create',compact('banks'));
    }

    public function getBankType(Request $request)
    {
        $bank = Bank::find($request->bank_id);
        if ($bank) {
            return response()->json(['bank_type' => $bank->bank_type]);
        }
        return response()->json(['error' => 'Bank not found'], 404);
    }


    public function store(Request $request)
    {
        $user=Auth::user();

        //  dd($request->all());
        $request->validate([
            'holder_name' => 'required',
            'bank_id' => 'required',
            'bank_account' => 'nullable|string|required_if:bank_type,bank_account',
            'pay_number' => 'nullable|string|required_if:bank_type,pay_number',
        ]);


            Account::create([
            'holder_name' => $request->holder_name,
            'bank_id' => $request->bank_id,
            'account_number' => $request->bank_account ?? null,
            'paynumber' => $request->pay_number ?? null,
            'user_id'=>$user->id,
          ]);



        $notification = array(
            'message' => 'Brand created successfully.',
            'alert-type' => 'success'
        );

        return redirect()->route('account.index')->with($notification);
    }
    public function show($id)
    {
        $banks = Bank::all();
        $account = Account::find($id);

        return view('account.show', compact('banks','account'));
    }

    public function edit($id)
    {
        $account = Account::FindOrFail($id);
        $banks=Bank::all();


        return view('account.edit', compact('banks','account'));
    }

    public function update(Request $request, Account $account)
    {
        // dd($id);
         $request->validate([
            'holder_name' => 'required',
            'bank_id' => 'required',
            'bank_account' => 'nullable|string|required_if:bank_type,bank_account',
            'pay_number' => 'nullable|string|required_if:bank_type,pay_number',
        ]);

        // $bank = Bank::FindOrFail($id);
        // dd($account->id);


           $account->update([
            'holder_name' => $request->holder_name,
            'bank_id' => $request->bank_id,
            'account_number' => $request->account_number ?? null,
            'paynumber' => $request->paynumber ?? null,
            'user_id'=>$account->user_id,
          ]);




        $notification = array(
            'message' => 'Account Updated Successfully',
            'alert-type' => 'success'
        );


        return redirect()->route('account.index')->with($notification);
    }

    public function destroy(Account $account)
    {



        $account->delete();
        $notification = array(
            'message' => 'Account Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('account.index')->with($notification);
    }
}
