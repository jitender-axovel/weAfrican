<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPortfolio extends Model
{
     protected $fillable = ['user_id', 'business_id', 'maritial_status', 'occupation', 'acedimic_status' ,'key_skills', 'experience_years', 'experience_months', 'height_feets', 'height_inches' , 'hair_type', 'skin_color' , 'hair_color' , 'professional_training', 'institute_name'];

    public static $updatable = ['user_id' => "", 'business_id' => "", 'maritial_status' => "", 'occupation' => "", 'acedimic_status' => "",'key_skills' => "", 'experience_years' => "", 'experience_months' => "", 'height_feets' => "", 'height_inches' => "", 'hair_type' => "", 'skin_color' => "", 'hair_color' => "", 'professional_training' => "", 'institute_name' => ""];

    public function portfolio_images()
    {
        return $this->hasMany('App\UserPortfolioImage','user_portfolio_id');
    }

    public function apiGetUserPortfolio($input)
    {
    	$portfolio = $this->wherebusinessId($input['businessId'])->first();
    	return $portfolio;
    }
}
