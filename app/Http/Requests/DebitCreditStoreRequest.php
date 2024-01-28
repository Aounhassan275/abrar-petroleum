<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DebitCreditStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
            
        $rules = [
            'sale_date' => 'required',
            'user_id' => 'required|numeric',
            'account_id.*' => 'required|numeric',
            'product_id.*' => 'nullable|numeric',
            'qty.*' => 'nullable|numeric',
            'debit.*' => 'nullable|numeric|required_without:credit.*',
            'credit.*' => 'nullable|numeric|required_without:debit.*',
        ];
        return $rules;
    }

    public function messages()
    {
        $customMessages = [];

            if($this->input('account_id') != null && count($this->input('account_id')) > 0)
            {
                for ($i = 0; $i < count($this->input('account_id')); $i++) {
                    $customMessages["account_id.$i.required"] = "Account Id field is Required for " . ($i + 1) . " Field.Please Add it.";
                    $customMessages["account_id.$i.numeric"] = "Account Id field  must be numeric for " . ($i + 1) . " Field.Please Fix it.";
                }
            }
            if($this->input('product_id') != null && count($this->input('product_id')) > 0)
            {
                for ($i = 0; $i < count($this->input('product_id')); $i++) {
                    $customMessages["product_id.$i.numeric"] = "Product Id field must be numeric for " . ($i + 1) . " Field.Please Fix it.";
                }
            }
            if($this->input('qty') != null && count($this->input('qty')) > 0)
            {
                for ($i = 0; $i < count($this->input('qty')); $i++) {
                    $customMessages["qty.$i.numeric"] = "Qty field must be numeric for " . ($i + 1) . " Field.Please Fix it.";
                }
            }
            if($this->input('debit') != null && count($this->input('debit')) > 0)
            {
                for ($i = 0; $i < count($this->input('debit')); $i++) {
                    $customMessages["debit.$i.numeric"] = "Debit field must be numeric for " . ($i + 1) . " Field.Please Fix it.";
                }
            }
            if($this->input('credit') != null && count($this->input('credit')) > 0)
            {
                for ($i = 0; $i < count($this->input('credit')); $i++) {
                    $customMessages["credit.$i.numeric"] = "Credit field must be numeric for " . ($i + 1) . " Field.Please Fix it.";
                }
            }
        return $customMessages;
    }
}
