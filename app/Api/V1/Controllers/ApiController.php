<?php

namespace App\Api\V1\Controllers;

//use JWTAuth;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Auth;

//requests
use App\Api\V1\Requests\ComputeMotorPremiumRequest;
use App\Api\V1\Requests\LoadRiskRequest;

//use App\Models\User;
use App\Models\Customer;
use App\Models\SalesChannel;
use App\Models\SalesType;
use App\Models\PolicyType;
use App\Models\Serials;
use App\Models\PolicyProductType;
use App\Models\VehicleModel;
use App\Models\VehicleMake;
use App\Models\VehicleType;
use App\Models\VehicleUse;
use App\Models\SelectStatus;
use App\Models\Currency;
use App\Models\FireRoofed;
use App\Models\FireWalled;
use App\Models\FireRisk;
use App\Models\FireDetails;
use App\Models\CollectionMode;
use App\Models\Policy;
use App\Models\MotorDetails;
use App\Models\Bill;
use App\Models\ProcessedPolicy;
use App\Models\TravelDetails;
use App\Models\Country;
use App\Models\Beneficiary;
use App\Models\MaritalStatus;
use App\Models\Accident;
use App\Models\NCD;
use App\Models\Loadings;
use App\Models\FleetDiscount;
use App\Models\BuyBackExcess;
use App\Models\BondTypes;
use App\Models\PendingBills;
use App\Models\ClaimProcessed;
use App\Models\HealthPlans;
use App\Models\LifePlans;
use App\Models\MediaFiles;

use App\Models\HealthDetail;
use App\Models\LifeDetail;

use App\Models\NatureofAcccident;
use App\Models\NatureofWork;

use App\Models\BondDetails;

use App\Models\MortgageCompanies;
use App\Models\PropertyType;
use App\Models\EngineeringDetails;
use App\Models\AccidentDetails;
use App\Models\AttachDocuments;
use App\Models\MarineDetails;
use App\Models\MarineRisktypes;
use App\Models\AccidentRiskType;
use App\Models\LiabilityRiskTypes;
use App\Models\LiabilityDetails;
use App\Models\EngineeringRisktypes;

use App\Models\Insurers;
use DB;
//use Auth;
use Activity;
use Input;
use Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use DateTime;
use Excel;
use PDF;
use Dompdf\Dompdf;
use Validator;

class ApiController extends Controller
{
    use Helpers;

    public function __construct()
    {
      global $postdata;

      header("Access-Control-Allow-Origin: *");
	    header("Content-Type: application/json; charset=UTF-8");
	    header("Access-Control-Allow-Methods: OPTIONS, GET, POST");

      $postdata = file_get_contents("php://input");

    }
    

    public function index()
    {	
    	//$currentUser = JWTAuth::parseToken()->authenticate();
        return response()->json([
            'title'   => 'Welcome to Phoenix Insurance',
            'message' => 'Buy & Pay for your Insurance policy or make claims.'
        ]);
        
    }

    public function loadvehicleuse()
    {   
        try
        {
                $vehicleuses  = VehicleUse::distinct()->get(['use'])->toArray();
                //distinct()->get(['risk'])
                /*$vehicle_use = Input::get("vehicle_use");
                $risk_types =VehicleUse::where('use',$vehicle_use)->distinct()->get(['risk']);*/
                //return json_encode($vehicleuses);
                return response()->json($vehicleuses);
        }

        catch (\Exception $e) 
        { 
               echo $e->getMessage();
            
        }
    }

    public function newpolicy()
    {
      
    $noclaimdiscount = NCD::all();
    $fleetdiscount = FleetDiscount::all();
    $vehiclemodels =  VehicleModel::all();
    $saleschannel = SalesChannel::all();
    $salestype    = SalesType::all();
    $insurers     = Insurers::orderby('name','asc')->get();
    $policytypes  = PolicyType::all();
    //$intermediary = User::orderby('username','ASC')->get();
    $vehiclemakes = VehicleMake::all();
    $vehicletypes = VehicleType::all();
    $vehicleuses  = VehicleUse::distinct()->get(['risk']);
    $beneficiaries= Beneficiary::all();
    $selectstatus = SelectStatus::all();
    $roofed       = FireRoofed::all();
    $walled       = FireWalled::all();
    $selectstatus = SelectStatus::all();
    $currencies   = Currency::all();
    $firerisks    = FireRisk::all();
    $collectionmodes = CollectionMode::all();
    $customers    = Customer::all();
    $countries    = Country::all();
    $maritalstatus= MaritalStatus::all();
    $bondtypes    = BondTypes::all();
    $natureofwork = NatureofWork::all();
    $natureofaccident = NatureofAcccident::all();
    $mortagecompanies = MortgageCompanies::all();
    $propertytypes    = PropertyType::all();
    $marinetypes      = MarineRisktypes::all();
    $engineeringrisktypes    = EngineeringRisktypes::all();
    $accidenttypes     = AccidentRiskType::all();
    $liabilitytypes    = LiabilityRiskTypes::all();
    $producttypes = PolicyProductType::orderby('type','asc')->get();
    $healthplans  = HealthPlans::all();
    $lifeplans  = LifePlans::all();
    $year = range( date("Y") , 1990 );

    return response()->json([
            'data'   => compact('intermediary','lifeplans','healthplans','liabilitytypes','accidenttypes','engineeringrisktypes','marinetypes','mortagecompanies','propertytypes','natureofwork','natureofaccident','bondtypes','producttypes','fleetdiscount','noclaimdiscount','vehiclemodels','year','beneficiaries','maritalstatus','countries','customers','collectionmodes','firerisks','roofed','walled','policytypes','insurers','saleschannel','salestype','vehicleuses','vehicletypes','vehiclemakes'),
            'currencies' => $currencies,
            'selectstatus' => $selectstatus
        ]);

   /* return view('policy.new', compact('intermediary','lifeplans','healthplans','liabilitytypes','accidenttypes','engineeringrisktypes','marinetypes','mortagecompanies','propertytypes','natureofwork','natureofaccident','bondtypes','producttypes','fleetdiscount','noclaimdiscount','vehiclemodels','year','beneficiaries','maritalstatus','countries','customers','collectionmodes','firerisks','roofed','walled','policytypes','insurers','saleschannel','salestype','vehicleuses','vehicletypes','vehiclemakes'))
    ->with('currencies',$currencies)
    ->with('selectstatus',$selectstatus);*/
    }
    public function expired()
    {
        $policies = ProcessedPolicy::where('insurance_period_to','<=',Carbon::now())->orderby('id','desc')->paginate(30);
        return View('policy.expired',compact('policies'));
    }


  

    public function excludePolicy()
   {
        if(Input::get("ID"))
        {
            $ID = Input::get("ID");
            $policynumber = Input::get("policynumber");

            $affectedRows = Policy::where('id', '=', $ID)->delete();

            if($affectedRows > 0)
            {

                MotorDetails::where('ref_number', '=', $policynumber)->delete();

                $ini   = array('OK'=>'OK');
                return  Response::json($ini);
            }
            else
            {
                $ini   = array('No Data'=>$ID);
                return  Response::json($ini);
            }
        }
        else
        {
           $ini   = array('No Data'=>'No Data');
           return  Response::json($ini);
        }

   }

    public function lockPolicy()
   {
        if(Input::get("ID"))
        {
            $ID = Input::get("ID");
            $affectedRows = Policy::where('id', '=', $ID)->update(array('status' => 'Locked'));

            if($affectedRows > 0)
            {
                $ini   = array('OK'=>'OK');
                return  Response::json($ini);
            }
            else
            {
                $ini   = array('No Data'=>$ID);
                return  Response::json($ini);
            }
        }
        else
        {
           $ini   = array('No Data'=>'No Data');
           return  Response::json($ini);
        }

   }

    public function suspendPolicy()
   {
        if(Input::get("ID"))
        {
            $ID = Input::get("ID");
            $affectedRows = Policy::where('id', '=', $ID)->update(array('status' => 'Suspended'));

            if($affectedRows > 0)
            {
                $ini   = array('OK'=>'OK');
                return  Response::json($ini);
            }
            else
            {
                $ini   = array('No Data'=>$ID);
                return  Response::json($ini);
            }
        }
        else
        {
           $ini   = array('No Data'=>'No Data');
           return  Response::json($ini);
        }

   }

   public function cancelPolicy()
   {
        if(Input::get("ID"))
        {
            $ID = Input::get("ID");
            $affectedRows = Policy::where('id', '=', $ID)->update(array('status' => 'Cancelled'));

            if($affectedRows > 0)
            {
                $ini   = array('OK'=>'OK');
                return  Response::json($ini);
            }
            else
            {
                $ini   = array('No Data'=>$ID);
                return  Response::json($ini);
            }
        }
        else
        {
           $ini   = array('No Data'=>'No Data');
           return  Response::json($ini);
        }

   }

   public function loadncd()
   {

     try
    {

            $vehicle_use = Input::get("vehicle_use");
            $use_types = NCD::where('use',$vehicle_use)->get();
            return  Response::json($use_types);
    }

    catch (\Exception $e) 
    { 
           echo $e->getMessage();
        
    }

   }

    public function loadrisk(LoadRiskRequest $request)
   {

     try
    {
    		//$request->only(['email', 'password']);
            $vehicle_use = $request->only(['vehicle_use']);
            $risk_types =VehicleUse::where('use',$vehicle_use)->distinct()->get(['risk']);
            return  Response::json($risk_types);
    }

    catch (\Exception $e) 
    { 
           echo $e->getMessage();
        
    }


   }


   public function loadvehiclemodels()
   {

     try
    {

            $vehicle_make = Input::get("vehicle_make");
            $models =VehicleModel::where('type',$vehicle_make)->distinct()->get(['model']);
            return  Response::json($models);
    }

    catch (\Exception $e) 
    { 
           echo $e->getMessage();
        
    }


   }

    public function loadinsurer()
   {

     try
    {

            $policytype = Input::get("policy_type");
            $insurer =Insurers::where('type',$policytype)->orderBy('name','asc')->get();
            return  Response::json($insurer);
    }

    catch (\Exception $e) 
    { 
           echo $e->getMessage();
        
    }


   }

    public function loadproduct()
   {

     try
    {

            $policytype = Input::get("policy_type");
            $productfetched =PolicyProductType::where('group',$policytype)->orderBy('type','asc')->get();
            return  Response::json($productfetched);
    }

    catch (\Exception $e) 
    { 
           echo $e->getMessage();
        
    }


   }



      public function viewPolicy($id)
    {

    
    $policydetails   =  ProcessedPolicy::where('id' ,'=', $id)->get()->first();
    $images          =  AttachDocuments::where('customer' ,'=', $policydetails->customer_number)->get();
    $balancesheet    =  Bill::where('reference_number' ,'=', $policydetails->ref_number)->get()->last();
    $bills           =  Bill::where('reference_number' ,'=', $policydetails->ref_number)->get();
    $claims          =  ClaimProcessed::where('policy_number' ,'=', $policydetails->ref_number)->get();
    $customers       =  Customer::where('id' ,'=', $policydetails->customer_number)->get()->first();

   

    switch($policydetails->policy_product) 
    {
        case 'Motor Insurance':
            $fetchrecord  = MotorDetails::where('ref_number','=',$policydetails->ref_number)->first();
             if(!$fetchrecord)
            {
               return view('errors.policynotexist');
            }
            break;
        case 'Travel Insurance':
             $fetchrecord = TravelDetails::where('ref_number','=',$policydetails->ref_number)->first();
            break;
        case 'Personal Accident Insurance':
             $fetchrecord = Accident::where('ref_number','=',$policydetails->ref_number)->first();
            break;

        case 'Fire Insurance':
             $fetchrecord = FireDetails::where('ref_number','=',$policydetails->ref_number)->first();
            break;

       case 'Bond Insurance':
             $fetchrecord = BondDetails::where('ref_number','=',$policydetails->ref_number)->first();
            break;

        case 'Marine Insurance':
             $fetchrecord = MarineDetails::where('ref_number','=',$policydetails->ref_number)->first();
            break;

        case 'Engineering Insurance':
             $fetchrecord = EngineeringDetails::where('ref_number','=',$policydetails->ref_number)->first();
            break;

        case 'Health Insurance':
             $fetchrecord = HealthDetail::where('ref_number','=',$policydetails->ref_number)->first();
            break;

        case 'Life Insurance':
             $fetchrecord = LifeDetail::where('ref_number','=',$policydetails->ref_number)->first();
            break;

        case 'Liability Insurance':
             $fetchrecord = LiabilityDetails::where('ref_number','=',$policydetails->ref_number)->first();
            break;

        case 'General Accident Insurance':
             $fetchrecord = AccidentDetails::where('ref_number','=',$policydetails->ref_number)->first();
            break;

      }

       //dd($fetchrecord);
    return view('policy.view', compact('policydetails','images','balancesheet','bills','claims','fetchrecord','customers'));
    }


     public function printPolicy($id)
    {


    $policydetails   =  ProcessedPolicy::where('id' ,'=', $id)->get()->first();
    $balancesheet    =  PendingBills::where('reference_number' ,'=', $policydetails->ref_number)->get()->first();
    $bills           =  PendingBills::where('reference_number' ,'=', $policydetails->ref_number)->get();
    $claims          =  ClaimProcessed::where('policy_number' ,'=', $policydetails->ref_number)->get();
    $customers       =  Customer::where('id' ,'=', $policydetails->customer_number)->get()->first();

    //dd($customers);
    switch($policydetails->policy_product) 
    {
        case 'Motor Insurance':
            $fetchrecord  = MotorDetails::where('ref_number','=',$policydetails->ref_number)->first();
            break;
        case 'Travel Insurance':
             $fetchrecord = TravelDetails::where('ref_number','=',$policydetails->ref_number)->first();
            break;
        case 'Personal Accident Insurance':
             $fetchrecord = Accident::where('ref_number','=',$policydetails->ref_number)->first();
            break;

       case 'Fire Insurance':
             $fetchrecord = FireDetails::where('ref_number','=',$policydetails->ref_number)->first();
            break;

       case 'Bond Insurance':
             $fetchrecord = BondDetails::where('ref_number','=',$policydetails->ref_number)->first();
            break;

        case 'Marine Insurance':
             $fetchrecord = MarineDetails::where('ref_number','=',$policydetails->ref_number)->first();
            break;

        
        case 'Engineering Insurance':
             $fetchrecord = EngineeringDetails::where('ref_number','=',$policydetails->ref_number)->first();
            break;

        case 'Health Insurance':
             $fetchrecord = HealthDetail::where('ref_number','=',$policydetails->ref_number)->first();
            break;

        case 'Life Insurance':
             $fetchrecord = LifeDetail::where('ref_number','=',$policydetails->ref_number)->first();
            break;

        case 'Liability Insurance':
             $fetchrecord = LiabilityDetails::where('ref_number','=',$policydetails->ref_number)->first();
            break;

        case 'General Accident Insurance':
             $fetchrecord = AccidentDetails::where('ref_number','=',$policydetails->ref_number)->first();
            break;

      }

      //dd($fetchrecord);

    return view('policy.print', compact('policydetails','balancesheet','bills','claims','fetchrecord','customers'));
    }


    public function downloadschedule($type)
    {


        $data = Customer::get()->toArray();
        return Excel::create('ListOfCustomers', function($excel) use ($data) {
            $excel->sheet('List', function($sheet) use ($data)
            {
               
                $sheet->protect('jason');
                $sheet->fromArray($data);
                $sheet->setAutoSize(true);
                // Set font
                $sheet->setStyle(array(
                'font' => array(
                    'name'      =>  'Calibri',
                    'size'      =>  10,
                    'bold'      =>  false
                    )
                ));

            });
        })->download($type);
        

    }


    public function motorfleetpolicy()
    {
      
    $noclaimdiscount = NCD::all();
    $fleetdiscount = FleetDiscount::all();
    $vehiclemodels =  VehicleModel::all();
    $saleschannel = SalesChannel::all();
    $salestype    = SalesType::all();
    $insurers     = Insurers::orderby('name','asc')->get();
    $policytypes  = PolicyType::all();
    $intermediary = User::orderby('username','ASC')->get();
    $vehiclemakes = VehicleMake::all();
    $vehicletypes = VehicleType::all();
    $vehicleuses  = VehicleUse::distinct()->get(['risk']);
    $beneficiaries= Beneficiary::all();
    $selectstatus = SelectStatus::all();
    $roofed       = FireRoofed::all();
    $walled       = FireWalled::all();
    $selectstatus = SelectStatus::all();
    $currencies   = Currency::all();
    $firerisks    = FireRisk::all();
    $collectionmodes = CollectionMode::all();
    $customers    = Customer::all();
    $countries    = Country::all();
    $maritalstatus= MaritalStatus::all();
    $bondtypes    = BondTypes::all();
    $natureofwork = NatureofWork::all();
    $natureofaccident = NatureofAcccident::all();
    $mortagecompanies = MortgageCompanies::all();
    $propertytypes    = PropertyType::all();
    $marinetypes      = MarineRisktypes::all();
    $engineeringrisktypes    = EngineeringRisktypes::all();
    $accidenttypes     = AccidentRiskType::all();
    $liabilitytypes    = LiabilityRiskTypes::all();
    $producttypes = PolicyProductType::orderby('type','asc')->get();
    $healthplans  = HealthPlans::all();
    $lifeplans  = LifePlans::all();
    $year = range( date("Y") , 1990 );

    return view('policy.fleet', compact('intermediary','lifeplans','healthplans','liabilitytypes','accidenttypes','engineeringrisktypes','marinetypes','mortagecompanies','propertytypes','natureofwork','natureofaccident','bondtypes','producttypes','fleetdiscount','noclaimdiscount','vehiclemodels','year','beneficiaries','maritalstatus','countries','customers','collectionmodes','firerisks','roofed','walled','policytypes','insurers','saleschannel','salestype','vehicleuses','vehicletypes','vehiclemakes'))
    ->with('currencies',$currencies)
    ->with('selectstatus',$selectstatus);
    }

    public function newpolicywithcustomer($id)
    {
      
    $noclaimdiscount = NCD::all();
    $fleetdiscount = FleetDiscount::all();
    $vehiclemodels =  VehicleModel::all();
    $saleschannel = SalesChannel::all();
    $salestype    = SalesType::all();
    $insurers     = Insurers::orderby('name','asc')->get();
    $policytypes  = PolicyType::all();
    $intermediary = User::orderby('username','ASC')->get();
    $vehiclemakes = VehicleMake::all();
    $vehicletypes = VehicleType::all();
    $vehicleuses  = VehicleUse::distinct()->get(['risk']);
    $beneficiaries= Beneficiary::all();
    $selectstatus = SelectStatus::all();
    $roofed       = FireRoofed::all();
    $walled       = FireWalled::all();
    $selectstatus = SelectStatus::all();
    $currencies   = Currency::all();
    $firerisks    = FireRisk::all();
    $collectionmodes = CollectionMode::all();
    $customers    = Customer::where('account_number',$id)->get();
    $countries    = Country::all();
    $maritalstatus= MaritalStatus::all();
    $bondtypes    = BondTypes::all();
    $natureofwork = NatureofWork::all();
    $natureofaccident = NatureofAcccident::all();
    $mortagecompanies = MortgageCompanies::all();
    $propertytypes    = PropertyType::all();
    $marinetypes      = MarineRisktypes::all();
    $engineeringrisktypes    = EngineeringRisktypes::all();
    $accidenttypes     = AccidentRiskType::all();
    $liabilitytypes    = LiabilityRiskTypes::all();
    $producttypes = PolicyProductType::orderby('type','asc')->get();
    $healthplans  = HealthPlans::all();
    $lifeplans  = LifePlans::all();
    $year = range( date("Y") , 1990 );

    return view('policy.new', compact('intermediary','lifeplans','healthplans','liabilitytypes','accidenttypes','engineeringrisktypes','marinetypes','mortagecompanies','propertytypes','natureofwork','natureofaccident','bondtypes','producttypes','fleetdiscount','noclaimdiscount','vehiclemodels','year','beneficiaries','maritalstatus','countries','customers','collectionmodes','firerisks','roofed','walled','policytypes','insurers','saleschannel','salestype','vehicleuses','vehicletypes','vehiclemakes'))
    ->with('currencies',$currencies)
    ->with('selectstatus',$selectstatus);
    }

    public function newquotation()
    {
    $noclaimdiscount = NCD::all();
    $fleetdiscount = FleetDiscount::all();
    $vehiclemodels =  VehicleModel::all();
    $saleschannel = SalesChannel::all();
    $salestype    = SalesType::all();
    $insurers     = Insurers::orderby('name','asc')->get();
    $policytypes  = PolicyType::all();
    $intermediary = User::orderby('username','ASC')->get();
    $vehiclemakes = VehicleMake::all();
    $vehicletypes = VehicleType::all();
    $vehicleuses  = VehicleUse::distinct()->get(['risk']);
    $beneficiaries= Beneficiary::all();
    $selectstatus = SelectStatus::all();
    $roofed       = FireRoofed::all();
    $walled       = FireWalled::all();
    $selectstatus = SelectStatus::all();
    $currencies   = Currency::all();
    $firerisks    = FireRisk::all();
    $collectionmodes = CollectionMode::all();
    $customers    = Customer::all();
    $countries    = Country::all();
    $maritalstatus= MaritalStatus::all();
    $bondtypes    = BondTypes::all();
    $natureofwork = NatureofWork::all();
    $natureofaccident = NatureofAcccident::all();
    $mortagecompanies = MortgageCompanies::all();
    $propertytypes    = PropertyType::all();
    $marinetypes      = MarineRisktypes::all();
    $engineeringrisktypes    = EngineeringRisktypes::all();
    $accidenttypes     = AccidentRiskType::all();
    $liabilitytypes    = LiabilityRiskTypes::all();
    $producttypes = PolicyProductType::orderby('type','asc')->get();
    $healthplans  = HealthPlans::all();
    $lifeplans  = LifePlans::all();
    $year = range( date("Y") , 1990 );

    return view('policy.quotation', compact('intermediary','lifeplans','healthplans','liabilitytypes','accidenttypes','engineeringrisktypes','marinetypes','mortagecompanies','propertytypes','natureofwork','natureofaccident','bondtypes','producttypes','fleetdiscount','noclaimdiscount','vehiclemodels','year','beneficiaries','maritalstatus','countries','customers','collectionmodes','firerisks','roofed','walled','policytypes','insurers','saleschannel','salestype','vehicleuses','vehicletypes','vehiclemakes'))
    ->with('currencies',$currencies)
    ->with('selectstatus',$selectstatus);

    }


    public function fleetcompute(Request $request)
    {

        $rules = array(
        'file' => 'required',
        
    );

    $validator = Validator::make(Input::all(), $rules);
    // process the form
    if ($validator->fails()) 
    {

       return redirect()
            ->route('online-policies/new')
            ->with('info','Fleet processing failed, Please verify all fields are correctly filled !');
    }
    else 
    {
        try {
            
          
           
           $file = Input::file('file');



           
          
         // $file->move('uploads', $file->getClientOriginalName());
          
        Excel::load($file, function($reader) {


                   //$policynumberval = Input::get('policy_number');
            
            //$invoicenumberval = $this->generateInoviceNumber(10);
            // Getting all results
        $results = $reader->get()->toArray();
            //var_dump($results);exit;
                foreach ($results as $key => $value) {



            $policynumberval = Input::get('policy_number');
            $policyref  = $this->generatePolicyNumber(Input::get('policy_product'));
            $invoicenumberval = $this->generateInoviceNumber(10);
            $time = explode(" - ", Input::get('insurance_period'));



        $policy                         = new Policy;
        $policy->customer_number        = Input::get('customer_number');  
        $policy->policy_type            = Input::get('policy_type');
        $policy->policy_product         = Input::get('policy_product');
        $policy->policy_insurer         = Input::get('policy_insurer'); 
        $policy->insurance_period_from  = $this->change_date_format($time[0]);
        $policy->insurance_period_to    = $this->change_date_format($time[1]);
        $policy->policy_sales_type      = Input::get('policy_sales_type');
        $policy->policy_sales_channel   = Input::get('policy_sales_channel');
        $policy->policy_number          = Input::get('policy_number');
        $policy->ref_number             = $policyref;
        $policy->policy_currency        = Input::get('policy_currency');
        $policy->status                 = 'Pending Payment';
        $policy->approved_by            = Auth::user()->getNameOrUsername();
        $policy->created_by             = Auth::user()->getNameOrUsername();
        $policy->created_on             = Carbon::now();
        $policy->save();

                
        $motor                              = new MotorDetails;
        $motor->preferedcover               = $value['preferedcover'];  
        $motor->vehicle_currency            = 'GHS';
        $motor->vehicle_value               = $value['vehicle_value'];
        $motor->vehicle_buy_back_excess     = $value['vehicle_buy_back_excess']; 
        $motor->vehicle_tppdl_value         = $value['vehicle_tppdl_value'];
        $motor->vehicle_body_type           = $value['vehicle_body_type'];
        $motor->vehicle_model               = $value['vehicle_model'];
        $motor->vehicle_make                = $value['vehicle_make'];
        $motor->vehicle_use                 = $value['vehicle_use'];
        $motor->vehicle_make_year           = $value['vehicle_make_year'];
        $motor->vehicle_seating_capacity    = $value['vehicle_seating_capacity'];
        $motor->vehicle_cubic_capacity      = $value['vehicle_cubic_capacity'];
        $motor->vehicle_registration_number = $value['vehicle_registration_number'];
        $motor->vehicle_chassis_number      = $value['vehicle_chassis_number'];
        $motor->ref_number                  = $policyref;
        $motor->vehicle_risk                = $value['vehicle_risk'];
        $motor->vehicle_ncd                 = 0;
        $motor->vehicle_fleet_discount      = 0;
        $motor->save();
        //Invoice Generation

   
        $bill                               = new Bill;
        $bill->invoice_number               = $invoicenumberval;
        $bill->account_number               = Input::get('customer_number');
        $bill->account_name                 = Input::get('billed_to'); 
        $bill->policy_number                = Input::get('policy_number');
        $bill->policy_product               = Input::get('policy_product');
        $bill->currency                     = Input::get('policy_currency');
        $bill->amount                       = $value['premium_payable']; 
        $bill->commission_rate              = $value['commission_rate']; 
        $bill->note                         = Input::get('collection_mode'); 
        $bill->reference_number             = $policyref; 
        $bill->status                       = 'Unpaid';   
        $bill->paid_amount                  = 0; 
        $bill->created_by                   = Auth::user()->getNameOrUsername();
        $bill->created_on                   = Carbon::now();
        $bill->save();

    }
        });

           
            return redirect()
            ->route('online-policies')
            ->with('info','Policy has successfully been uploaded!');



        } 
        catch (\Exception $e) {
           
           echo $e->getMessage();
            
        }
    } 
} 

    
    public function generatePolicyNumber($policytype)
    
    {

    $number = Serials::where('name','=','policy')->first();
    $number = $number->counter;
    $policynumber = str_pad($number+1,7, '0', STR_PAD_LEFT);
    
    $generate = '';
    switch($policytype) 
    {
        case 'Motor Insurance':
           $generate= 'P'.$policynumber;
            break;
        case 'Travel Insurance':
             $generate= 'T'.$policynumber;
            break;
        case 'Personal Accident Insurance':
              $generate= 'PA'.$policynumber;
            break;
        case 'Fire Insurance':
             $generate= 'F'.$policynumber;
            break;

       case 'Bond Insurance':
              $generate= 'B'.$policynumber;
            break;

        case 'Marine Insurance':
              $generate= 'M'.$policynumber;
            break;

        case 'Engineering Insurance':
             $generate= 'E'.$policynumber;
            break;

        case 'Health Insurance':
             $generate= 'H'.$policynumber;
            break;

        case 'Life Insurance':
             $generate= 'Y'.$policynumber;
            break;

        case 'Liability Insurance':
             $generate= 'L'.$policynumber;
            break;


        case 'General Accident Insurance':
              $generate= 'GA'.$policynumber;
            break;

      }
       Serials::where('name','=','policy')->increment('counter',1);
      return  $generate;
    }

    public function generateInoviceNumber()
    {
    $number = Serials::where('name','=','invoice')->first();
    $number = $number->counter;
    $account = str_pad($number,7, '0', STR_PAD_LEFT);
    $myaccount= 'INV'.$account;

    Serials::where('name','=','invoice')->increment('counter',1);
    return  $myaccount;
    }




    public function change_date_format($date)
    {
        $time = DateTime::createFromFormat('d/m/Y', $date);
        return $time->format('Y-m-d');
    }


    public function getSearchResults(Request $request)
    {
      

        $this->validate($request, [
            'search' => 'required'
        ]);

        $search = $request->get('search');

        $policies = ProcessedPolicy::where('fullname', 'like', "%$search%")
            ->orWhere('policy_insurer', 'like', "%$search%")
            ->orWhere('policy_product', 'like', "%$search%")
             ->orWhere('vehicle_registration_number', 'like', "%$search%")
             ->orWhere('policy_number', 'like', "%$search%")
            ->orderBy('fullname')
            ->paginate(30)
            ->appends(['search' => $search])
        ;


        return View('policy.index',compact('policies'));
  
    }

     public function updateClaim(Request $request)
    {

      try {

             $affectedRows = Claim::where('claim_number','=' , $request->input('claimid'))
            ->update(array(
                           
                           'status_of_claim' =>  $request->input('status_of_claim'),
                           'insurer_reference_id' =>  $request->input('insurer_reference_id'),
                           'loss_date' => $this->change_date_format($request->input('loss_date')), 
                           'submit_broker_date' => $this->change_date_format($request->input('submit_broker_date')), 
                           'submit_insurer_date' => $this->change_date_format($request->input('submit_insurer_date')), 
                           'settlement_date' =>  $this->change_date_format($request->input('settlement_date')), 
                           'location_of_loss'=>$request->input('location_of_loss'),
                           'loss_amount'=>$request->input('loss_amount'),
                           'excess_amount' => $request->input('excess_amount'),
                           'insurer_contact_name'=> $request->input('insurer_contact_name'),
                           'insurer_contact_email'=>$request->input('insurer_contact_email'),
                           'insurer_contact_phone'=>$request->input('insurer_contact_phone'),
                           'loss_cause'=> $request->input('loss_cause'),
                           'loss_description' => $request->input('loss_description'),
                           'updated_by'=> Auth::user()->getNameOrUsername(),
                           'updated_on'=>Carbon::now()));

            if($affectedRows > 0)
            {
                Activity::log([
          'contentId'   =>  $request->input('policy_number'),
          'contentType' => 'User',
          'action'      => 'Update',
          'description' => 'Updated claims details of '.$request->input('policy_number'),
          'details'     => 'Username: '.Auth::user()->getNameOrUsername(),
          ]);
        
             
              return redirect()
            ->route('claims')
            ->with('success','Claim has successfully been updated!');
            }
            else
            {
               return redirect()
            ->route('claims')
            ->with('error','Claim failed to update!');
            }
          }


    catch (\Exception $e) {
           
           echo $e->getMessage();
            
        }
           

    }

 

      public function editPolicy($id)
    {

   $noclaimdiscount = NCD::all();
    $fleetdiscount = FleetDiscount::all();
    $vehiclemodels =  VehicleModel::all();
    $saleschannel = SalesChannel::all();
    $salestype    = SalesType::all();
    $insurers     = Insurers::orderby('name','asc')->get();
    $policytypes  = PolicyType::all();
    $intermediary = User::orderby('username','ASC')->get();
    $vehiclemakes = VehicleMake::all();
    $vehicletypes = VehicleType::all();
    $vehicleuses  = VehicleUse::distinct()->get(['risk']);
    $beneficiaries= Beneficiary::all();
    $selectstatus = SelectStatus::all();
    $roofed       = FireRoofed::all();
    $walled       = FireWalled::all();
    $selectstatus = SelectStatus::all();
    $currencies   = Currency::all();
    $firerisks    = FireRisk::all();
    $collectionmodes = CollectionMode::all();
    $customers    = Customer::all();
    $countries    = Country::all();
    $maritalstatus= MaritalStatus::all();
    $bondtypes    = BondTypes::all();
    $natureofwork= NatureofWork::all();
    $natureofaccident    = NatureofAcccident::all();
    $mortagecompanies = MortgageCompanies::all();
    $propertytypes    = PropertyType::all();
    $marinetypes    = MarineRisktypes::all();
    $engineeringrisktypes    = EngineeringRisktypes::all();
    $accidenttypes    = AccidentRiskType::all();
    $liabilitytypes    = LiabilityRiskTypes::all();
    $producttypes =PolicyProductType::orderby('type','asc')->get();
    $year = range( date("Y") , 1990 );
    $healthplans  = HealthPlans::all();
    $lifeplans  = LifePlans::all();

    $policy = ProcessedPolicy::find($id);
    $bills = PendingBills::where('reference_number',$policy->ref_number)->first();

    
   //dd($policy->ref_number);

    switch($policy->policy_product) 
    {
        case 'Motor Insurance':
            $fetchrecord  = MotorDetails::where('ref_number','=',$policy->ref_number)->first();
            if(!$fetchrecord)
            {
               return view('errors.policynotexist');
            }

            break;
        case 'Travel Insurance':
             $fetchrecord = TravelDetails::where('ref_number','=',$policy->ref_number)->first();
            break;
        case 'Personal Accident Insurance':
             $fetchrecord = Accident::where('ref_number','=',$policy->ref_number)->first();
            break;
        case 'Fire Insurance':
             $fetchrecord = FireDetails::where('ref_number','=',$policy->ref_number)->first();
            break;

       case 'Bond Insurance':
             $fetchrecord = BondDetails::where('ref_number','=',$policy->ref_number)->first();
            break;

        case 'Marine Insurance':
             $fetchrecord = MarineDetails::where('ref_number','=',$policy->ref_number)->first();
            break;

        case 'Engineering Insurance':
             $fetchrecord = EngineeringDetails::where('ref_number','=',$policy->ref_number)->first();
            break;

        case 'Health Insurance':
             $fetchrecord = HealthDetail::where('ref_number','=',$policy->ref_number)->first();
            break;

        case 'Life Insurance':
             $fetchrecord = LifeDetail::where('ref_number','=',$policy->ref_number)->first();
            break;

        case 'Liability Insurance':
             $fetchrecord = LiabilityDetails::where('ref_number','=',$policy->ref_number)->first();
            break;


        case 'General Accident Insurance':
             $fetchrecord = AccidentDetails::where('ref_number','=',$policy->ref_number)->first();
            break;

      }

    //dd($policy);
    return view('policy.edit', compact('policy','bills','lifeplans','healthplans','fetchrecord','intermediary','liabilitytypes','accidenttypes','engineeringrisktypes','marinetypes','mortagecompanies','propertytypes','natureofwork','natureofaccident','bondtypes','producttypes','fleetdiscount','noclaimdiscount','vehiclemodels','year','beneficiaries','maritalstatus','countries','customers','collectionmodes','firerisks','roofed','walled','policytypes','insurers','saleschannel','salestype','vehicleuses','vehicletypes','vehiclemakes'))
    ->with('currencies',$currencies)
    ->with('selectstatus',$selectstatus);
   
    
    } 

    public function Renew($id)
    {

   $noclaimdiscount = NCD::all();
    $fleetdiscount = FleetDiscount::all();
    $vehiclemodels = VehicleModel::all();
    $saleschannel = SalesChannel::all();
    $salestype    = SalesType::all();
    $insurers     = Insurers::orderby('name','asc')->get();
    $policytypes  = PolicyType::all();
    $intermediary = User::orderby('username','ASC')->get();
    $vehiclemakes = VehicleMake::all();
    $vehicletypes = VehicleType::all();
    $vehicleuses  = VehicleUse::distinct()->get(['risk']);
    $beneficiaries= Beneficiary::all();
    $selectstatus = SelectStatus::all();
    $roofed       = FireRoofed::all();
    $walled       = FireWalled::all();
    $selectstatus = SelectStatus::all();
    $currencies   = Currency::all();
    $firerisks    = FireRisk::all();
    $collectionmodes = CollectionMode::all();
    $customers    = Customer::all();
    $countries    = Country::all();
    $maritalstatus= MaritalStatus::all();
    $bondtypes    = BondTypes::all();
    $natureofwork= NatureofWork::all();
    $natureofaccident    = NatureofAcccident::all();
    $mortagecompanies = MortgageCompanies::all();
    $propertytypes    = PropertyType::all();
    $marinetypes    = MarineRisktypes::all();
    $engineeringrisktypes    = EngineeringRisktypes::all();
    $accidenttypes    = AccidentRiskType::all();
    $liabilitytypes    = LiabilityRiskTypes::all();
    $producttypes =PolicyProductType::orderby('type','asc')->get();
    $year = range( date("Y") , 1990 );
    $healthplans  = HealthPlans::all();
    $lifeplans  = LifePlans::all();

    $policy = ProcessedPolicy::find($id);
    $bills = PendingBills::where('reference_number',$policy->ref_number)->first();

    
    

    switch($policy->policy_product) 
    {
        case 'Motor Insurance':
            $fetchrecord  = MotorDetails::where('ref_number','=',$policy->ref_number)->first();
             if(!$fetchrecord)
            {
               return view('errors.policynotexist');
            }
            break;
        case 'Travel Insurance':
             $fetchrecord = TravelDetails::where('ref_number','=',$policy->ref_number)->first();
            break;
        case 'Personal Accident Insurance':
             $fetchrecord = Accident::where('ref_number','=',$policy->ref_number)->first();
            break;
        case 'Fire Insurance':
             $fetchrecord = FireDetails::where('ref_number','=',$policy->ref_number)->first();
            break;

       case 'Bond Insurance':
             $fetchrecord = BondDetails::where('ref_number','=',$policy->ref_number)->first();
            break;

        case 'Marine Insurance':
             $fetchrecord = MarineDetails::where('ref_number','=',$policy->ref_number)->first();
            break;

        case 'Engineering Insurance':
             $fetchrecord = EngineeringDetails::where('ref_number','=',$policy->ref_number)->first();
            break;

        case 'Health Insurance':
             $fetchrecord = HealthDetail::where('ref_number','=',$policy->ref_number)->first();
            break;

        case 'Life Insurance':
             $fetchrecord = LifeDetail::where('ref_number','=',$policy->ref_number)->first();
            break;

        case 'Liability Insurance':
             $fetchrecord = LiabilityDetails::where('ref_number','=',$policy->ref_number)->first();
            break;


        case 'General Accident Insurance':
             $fetchrecord = AccidentDetails::where('ref_number','=',$policy->ref_number)->first();
            break;

      }

    //dd($year);
    return view('policy.renew', compact('policy','bills','lifeplans','healthplans','fetchrecord','intermediary','liabilitytypes','accidenttypes','engineeringrisktypes','marinetypes','mortagecompanies','propertytypes','natureofwork','natureofaccident','bondtypes','producttypes','fleetdiscount','noclaimdiscount','vehiclemodels','year','beneficiaries','maritalstatus','countries','customers','collectionmodes','firerisks','roofed','walled','policytypes','insurers','saleschannel','salestype','vehicleuses','vehicletypes','vehiclemakes'))
    ->with('currencies',$currencies)
    ->with('selectstatus',$selectstatus);
   
    
    } 

    public function computeMotorPremium()
    {
      global $postdata;
      //ComputeMotorPremiumRequest $request
      $requested = json_decode($postdata);

    	/*return response()->json([
            'message' => $requested
        ]);*/

          $vehiclerisk          = $requested->vehicle_risk;
          $vehicleuse           = $requested->vehicle_use;
          $vehiclecover         = $requested->vehicle_cover;

          $buybackexcessstatus  = $requested->vehicle_buy_back_excess;
          $suminsured           = $requested->vehicle_value;
          $seatnumber           = $requested->vehicle_seating_capacity;
          $vehiclebuildyear     = $requested->vehicle_make_year;
          $vehicletppdl         = ($requested->vehicle_tppdl_value) ? $requested->vehicle_tppdl_value : 0.000;
          //($requested->vehicle_tppdl_value) ? $requested->vehicle_tppdl_value : 0.000
          //$requested->vehicle_tppdl_value;
          $vehiclevoluntaryexcess = 0;
          $vehicelcubiccapacity = $requested->vehicle_cubic_capacity;
          $ncd_rate             = 0.000; //$requested->vehicle_ncd;
          $fleet_rate           = 0.000; //$requested->vehicle_fleet_discount;
          $vehiclecurrency      = $requested->vehicle_currency;
          $vehicle_buy_back_excess  = $requested->vehicle_buy_back_excess;

          

        $loading = Loadings::where('cover', $vehiclecover)
        ->where('use',$vehicleuse)
        ->where('risk',$vehiclerisk)
        ->get()
        ->first();

          $excess = BuyBackExcess::where('cover',$vehiclecover)
        ->where('use',$vehicleuse)
        ->where('risk',$vehiclerisk)
        ->get()
        ->first();

          
         
          //loadings
          $cover                = $loading->cover;
          $use                  = $loading->use;
          $risk                 = $loading->risk;
          $basic_premium        = $loading->basic_premium;
          $addition_perils      = $loading->addition_perils;
          $eco_perils           = $loading->eco_perils;
          $emergency_treatment  = $loading->emergency_treatment;
          $pa_benefit           = $loading->pa_benefit;
          $tppdl                = $loading->tppdl;
          $ncd                  = $loading->ncd;
          $nic                  = $loading->nic;
          $nhis                 = $loading->nhis;
          $nrsc                 = $loading->nrsc;
          $rate                 = $loading->rate;
          $tppdl_rate           = $loading->tppdl_rate;
          $seat_limit           = $loading->seat_limit;
          $seat_charge_rate     = $loading->seat_charge;
          $brown_card           = $loading->brown_card;
          $tpi                  = $loading->tpi;
          $tpi_limit            = $loading->tpi_limit;
          $extra_tppdl          = $loading->extra_tppdl;

          $tpicharge            = floatval($loading->tpi_limit) * floatval($loading->tpi);
          $tppdlcharge          = floatval($loading->tppdl) * floatval($loading->tppdl_rate);

          //return response()->json(['message' => 'I am here some!']);

          if($vehiclecover == 'Third party')
          {
             $execessbought = 0;
          }
          else if($buybackexcessstatus=='No')
          {
            $execessbought = 0;
          }

          else
          {
          //compute Excess
          $buy_back_yes         = $excess->yes;
          $excess_charge_rate   = $excess->charge;
          $execessbought        = ((floatval($suminsured) * (floatval($rate) / 100)) * (floatval($buy_back_yes)/100));
        }


          //compute Age Charge
          $vehicelyear = Carbon::createFromDate($vehiclebuildyear)->age;
          if($vehicelyear > 10 ) { $vehiceage_charge_rate = 0.07500; } 
          else if($vehicelyear > 5 && $vehicelyear <= 10 ) { $vehiceage_charge_rate = 0.05000; } 
          else { $vehiceage_charge_rate = 0.0; }
          $vehicleyearcharge = ((floatval($suminsured) * (floatval($rate) / 100)) + ($tpicharge + $tppdlcharge)) * $vehiceage_charge_rate;

           //compute Cubic Capacity Charge
          if($vehicelcubiccapacity > 2000 ) { $cubiccapacity_charge_rate = 0.10000; } 
          else if($vehicelcubiccapacity > 1600 & $vehicelyear <= 2000 ) { $cubiccapacity_charge_rate = 0.05000; } 
          else { $cubiccapacity_charge_rate = 0.0; }
          $vehiclecubiccharge = ((floatval($suminsured) * ($rate / 100)) + ($tpicharge + $tppdlcharge)) * $cubiccapacity_charge_rate;

          //compute Driving Experience Charge
          $drivingexperience = 0;

          //Compute Seat charge
          
          $seatchargeamount = ($seatnumber - $seat_limit) * $seat_charge_rate;

          //Emergency Treatment
          $emergencytreatmentcharge = $emergency_treatment * $seatnumber ;

          //compute Basic premium
           $basicpremiumcharge = ((floatval($suminsured) * ($rate / 100)) + ($tpicharge + $tppdlcharge)) + $vehiclecubiccharge + $vehicleyearcharge;
           $basicpremiumcharge_init = $tpicharge + $tppdlcharge;


          //compute extra tppdl
           $extratppdl = ($vehicletppdl - $tppdl) * $extra_tppdl ;


          //compute voluntary excess
           $voluntaryexcesscharge = ($vehiclevoluntaryexcess/100) * $basicpremiumcharge ;


           //Compute NCD
           $ncdamount = $basicpremiumcharge * $ncd_rate;

           //Premium less ncd
           $premium_less_ncd = $basicpremiumcharge - $ncdamount;

           //Compute Fleet Discount
           $fleetdiscountamount =  $premium_less_ncd *  ($fleet_rate /100) ;

           //Office Premium 
           $officepremiumcharge =  $basicpremiumcharge;

           //Premium less ncd and fleet
           $premium_less_ncd_fleet = $premium_less_ncd - $fleetdiscountamount;

           //Annual Premium Payable
           if($vehiclecover == 'Third party')
           {
            $payableanually = $premium_less_ncd_fleet + $seatchargeamount + $extratppdl + $drivingexperience + $pa_benefit + $eco_perils + $nic + $nhis + $addition_perils + $brown_card;
           }
           else
           {
           $payableanually = $premium_less_ncd_fleet + $execessbought +  $drivingexperience + $pa_benefit + $eco_perils + $seatchargeamount + $extratppdl - $voluntaryexcesscharge + $addition_perils + $nic + $nhis +  $nrsc + $brown_card;
           }
           //dd($payableanually); 'Premium'=>
            $added_response = array($payableanually);
            return  Response::json($added_response);

    }

    public function createPolicy(Request $request)
    {
            $this->validate($request,[
             'customer_number'=> 'required',
             'policy_product'=> 'required',
             'policy_insurer'=> 'required',
             'policy_type'=> 'required',
             'gross_premium' => 'required',
             'commission_rate' => 'required',
             'collection_mode' => 'required'
           ]); 

        
        $policynumberval = $request->input('policy_number');
        $policyref  = $this->generatePolicyNumber($request->input('policy_product'));
        $invoicenumberval = $this->generateInoviceNumber(10);

        if($request->input('policy_product')=='Motor Insurance')
        {
        

        $time = explode(" - ", $request->input('insurance_period'));

        
        //Policy Details
        $policy                         = new Policy;
        $policy->customer_number        = $request->input('customer_number');  
        $policy->policy_type            = $request->input('policy_type');
        $policy->policy_product         = $request->input('policy_product');
        $policy->policy_insurer         = $request->input('policy_insurer'); 
        $policy->insurance_period_from  = $this->change_date_format($time[0]);
        $policy->insurance_period_to    = $this->change_date_format($time[1]);
        $policy->policy_sales_type      = $request->input('policy_sales_type');
        $policy->policy_sales_channel   = $request->input('policy_sales_channel');
        $policy->policy_number          = $request->input('policy_number');
        $policy->ref_number             = $policyref;
        $policy->policy_currency        = $request->input('policy_currency');
        $policy->status                 = 'Pending Payment';
        $policy->approved_by            = Auth::user()->getNameOrUsername();
        $policy->created_by             = Auth::user()->getNameOrUsername();
        $policy->created_on             = Carbon::now();


        //Motor Details
        $motor                              = new MotorDetails;
        $motor->preferedcover               = $request->input('preferedcover');  
        $motor->vehicle_currency            = $request->input('vehicle_currency');
        $motor->vehicle_value               = $request->input('vehicle_value');
        $motor->vehicle_buy_back_excess     = $request->input('vehicle_buy_back_excess'); 
        $motor->vehicle_tppdl_standard      = $request->input('vehicle_tppdl_standard'); 
        $motor->vehicle_tppdl_value         = $request->input('vehicle_tppdl_value');
        $motor->vehicle_body_type           = $request->input('vehicle_body_type');
        $motor->vehicle_model               = $request->input('vehicle_model');
        $motor->vehicle_make                = $request->input('vehicle_make');
        $motor->vehicle_use                 = $request->input('vehicle_use');
        $motor->vehicle_make_year           = $request->input('vehicle_make_year');
        $motor->vehicle_seating_capacity    = $request->input('vehicle_seating_capacity');
        $motor->vehicle_cubic_capacity      = $request->input('vehicle_cubic_capacity');
        $motor->vehicle_registration_number = $request->input('vehicle_registration_number');
        $motor->vehicle_chassis_number      = $request->input('vehicle_chassis_number');
        $motor->vehicle_interest_status     = $request->input('vehicle_interest_status');

        $motor->vehicle_interest_name       = $request->input('vehicle_interest_name');
        $motor->vehicle_declined_status     = $request->input('vehicle_declined_status');
        $motor->vehicle_declined_reason     = $request->input('vehicle_declined_reason');
        $motor->vehicle_cancelled_status    = $request->input('vehicle_cancelled_status');
        $motor->vehicle_cancelled_reason    = $request->input('vehicle_cancelled_reason');
        $motor->ref_number                  = $policyref;
        $motor->vehicle_risk                = $request->input('vehicle_risk');
        $motor->vehicle_ncd                 = $request->input('vehicle_ncd');
        $motor->vehicle_fleet_discount      = $request->input('vehicle_fleet_discount');

        //Invoice Generation

   
        $bill                               = new Bill;
        $bill->invoice_number               = $invoicenumberval;
        $bill->account_number               = $request->input('customer_number');
        $bill->account_name                 = $request->input('billed_to'); 
        $bill->policy_number                = $request->input('policy_number');
        $bill->policy_product               = $request->input('policy_product');
        $bill->currency                     = $request->input('policy_currency');
        $bill->amount                       = $request->input('gross_premium'); 
        $bill->commission_rate              = $request->input('commission_rate'); 
        $bill->note                         = $request->input('collection_mode'); 
        $bill->reference_number             = $policyref; 
        $bill->status                       = 'Unpaid';   
        $bill->paid_amount                  = 0; 
        $bill->created_by                   = Auth::user()->getNameOrUsername();
        $bill->created_on                   = Carbon::now();



         if($policy->save())
          {


                            if($motor->save())  
                                { 


                                    if($bill->save())
                                    {                 
                                   Activity::log([
                                  'contentId'   =>  $request->input('account_number'),
                                  'contentType' => 'User',
                                  'action'      => 'Create',
                                  'description' => 'Policy '.$policynumberval.' - '.$request->input('billed_to').' was created successfully!',
                                  'details'     => 'Username: '.Auth::user()->getNameOrUsername(),
                                  ]);
                                
                                    return redirect()
                                    ->route('invoice')
                                    ->with('success','Policy has successfully been created!');

                                    }

                                    else
                                      {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Invoice failed to create!');
                                      }


                                }

                                else
                                  {

                                     return redirect()
                                    ->route('online-policies')
                                    ->with('error','Motor details failed to create!');
                                  }


          }

          else
          {

             return redirect()
            ->route('online-policies')
            ->with('error','Policy details failed to create!');
          }
      }

  //Fire Policy
   
 if($request->input('policy_product')=='Fire Insurance')
        {
    $time = explode(" - ", $request->input('insurance_period'));

        //$policynumberval = $this->generatePolicyNumber(10);
        //Policy Details
        $policy                         = new Policy;
        $policy->customer_number        = $request->input('customer_number');  
        $policy->policy_type            = $request->input('policy_type');
        $policy->policy_product         = $request->input('policy_product');
        $policy->policy_insurer         = $request->input('policy_insurer'); 
        $policy->insurance_period_from  = $this->change_date_format($time[0]);
        $policy->insurance_period_to    = $this->change_date_format($time[1]);
        $policy->policy_sales_type      = $request->input('policy_sales_type');
        $policy->policy_sales_channel   = $request->input('policy_sales_channel');
        $policy->policy_number          = $request->input('policy_number');
        $policy->ref_number             = $policyref;
        $policy->policy_currency        = $request->input('policy_currency');
        $policy->status                 = 'Pending Payment';
        $policy->approved_by            = Auth::user()->getNameOrUsername();
        $policy->created_by             = Auth::user()->getNameOrUsername();
        $policy->created_on             = Carbon::now();


        //Fire Details
        $fire                                   = new FireDetails;
        $fire->fire_risk_covered                = $request->input('fire_risk_covered');  
        $fire->fire_building_cost               = $request->input('fire_building_cost');
        $fire->fire_deductible                  = $request->input('fire_deductible');
        $fire->fire_personal_property_coverage  = $request->input('fire_personal_property_coverage'); 
        $fire->fire_temporary_rental_cost       = $request->input('fire_temporary_rental_cost'); 
        $fire->fire_building_address            = $request->input('fire_building_address');
        $fire->fire_property_type               = $request->input('fire_property_type');
        $fire->walled_with                      = $request->input('walled_with');
        $fire->roofed_with                      = $request->input('roofed_with');
        $fire->fire_mortgage_status             = $request->input('fire_mortgage_status');

        $fire->fire_mortgage_company            = $request->input('fire_mortgage_company');
        $fire->property_content                 = $request->input('property_content');
        $fire->created_on                       = Carbon::now();
        $fire->created_by                       = Auth::user()->getNameOrUsername();
        $fire->ref_number                       = $policyref;

        //Invoice Generation

   
        $bill                               = new Bill;
        $bill->invoice_number               = $invoicenumberval;
        $bill->account_number               = $request->input('customer_number');
        $bill->account_name                 = $request->input('billed_to'); 
        $bill->policy_number                = $request->input('policy_number');
        $bill->policy_product               = $request->input('policy_product');
        $bill->currency                     = $request->input('policy_currency');
        $bill->amount                       = $request->input('gross_premium'); 
        $bill->commission_rate              = $request->input('commission_rate'); 
        $bill->note                         = $request->input('collection_mode'); 
        $bill->reference_number             = $policyref; 
        $bill->status                       = 'Unpaid';   
        $bill->paid_amount                  = 0; 
        $bill->created_by                   = Auth::user()->getNameOrUsername();
        $bill->created_on                   = Carbon::now();



         if($policy->save())
          {


                            if($fire->save())  
                                { 


                                    if($bill->save())
                                    {                 
                                   Activity::log([
                                  'contentId'   =>  $request->input('account_number'),
                                  'contentType' => 'User',
                                  'action'      => 'Create',
                                  'description' => 'Policy '.$policynumberval.' - '.$request->input('billed_to').' was created successfully!',
                                  'details'     => 'Username: '.Auth::user()->getNameOrUsername(),
                                  ]);
                                
                                    return redirect()
                                    ->route('invoice')
                                    ->with('success','Policy has successfully been created!');

                                    }

                                    else
                                      {

                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to create!');
                                      }



                                }

                                else
                                  {

                                     return redirect()
                                    ->route('online-policies')
                                    ->with('error','Policy failed to create!');
                                  }


          }

          else
          {

             return redirect()
            ->route('online-policies')
            ->with('error','Policy failed to create!');
          }
      }
    
//Marine Insurance

if($request->input('policy_product')=='Marine Insurance')
        {
    $time = explode(" - ", $request->input('insurance_period'));

        //$policynumberval = $this->generatePolicyNumber(10);
        //Policy Details
        $policy                         = new Policy;
        $policy->customer_number        = $request->input('customer_number');  
        $policy->policy_type            = $request->input('policy_type');
        $policy->policy_product         = $request->input('policy_product');
        $policy->policy_insurer         = $request->input('policy_insurer'); 
        $policy->insurance_period_from  = $this->change_date_format($time[0]);
        $policy->insurance_period_to    = $this->change_date_format($time[1]);
        $policy->policy_sales_type      = $request->input('policy_sales_type');
        $policy->policy_sales_channel   = $request->input('policy_sales_channel');
        $policy->policy_number          = $request->input('policy_number');
        $policy->ref_number             = $policyref;
        $policy->policy_currency        = $request->input('policy_currency');
        $policy->status                 = 'Pending Payment';
        $policy->approved_by            = Auth::user()->getNameOrUsername();
        $policy->created_by             = Auth::user()->getNameOrUsername();
        $policy->created_on             = Carbon::now();


        //Fire Details
        $marine                                   = new MarineDetails;
        $marine->marine_risk_type                 = $request->input('marine_risk_type');  
        $marine->marine_sum_insured               = $request->input('marine_sum_insured');
        $marine->marine_bill_landing              = $request->input('marine_bill_landing');
        $marine->marine_interest                  = $request->input('marine_interest'); 
        $marine->marine_vessel                    = $request->input('marine_vessel'); 
        $marine->marine_insurance_condition       = $request->input('marine_insurance_condition');
        $marine->marine_valuation                 = $request->input('marine_valuation');
        $marine->marine_means_of_conveyance       = $request->input('marine_means_of_conveyance');
        $marine->marine_voyage                    = $request->input('marine_voyage');
        $marine->marine_condition                 = $request->input('marine_condition');
        $marine->created_on                       = Carbon::now();
        $marine->created_by                       = Auth::user()->getNameOrUsername();
        $marine->ref_number                       = $policyref; 

        //Invoice Generation

   
        $bill                               = new Bill;
        $bill->invoice_number               = $invoicenumberval;
        $bill->account_number               = $request->input('customer_number');
        $bill->account_name                 = $request->input('billed_to'); 
        $bill->policy_number                = $request->input('policy_number');
        $bill->policy_product               = $request->input('policy_product');
        $bill->currency                     = $request->input('policy_currency');
        $bill->amount                       = $request->input('gross_premium'); 
        $bill->commission_rate              = $request->input('commission_rate'); 
        $bill->note                         = $request->input('collection_mode'); 
        $bill->reference_number             = $policyref; 
        $bill->status                       = 'Unpaid';   
        $bill->paid_amount                  = 0; 
        $bill->created_by                   = Auth::user()->getNameOrUsername();
        $bill->created_on                   = Carbon::now();




         if($policy->save())
          {


                            if($marine->save())  
                                { 


                                    if($bill->save())
                                    {                 
                                   Activity::log([
                                  'contentId'   =>  $request->input('account_number'),
                                  'contentType' => 'User',
                                  'action'      => 'Create',
                                  'description' => 'Policy '.$policynumberval.' - '.$request->input('billed_to').' was created successfully!',
                                  'details'     => 'Username: '.Auth::user()->getNameOrUsername(),
                                  ]);
                                
                                    return redirect()
                                    ->route('invoice')
                                    ->with('success','Policy has successfully been created!');

                                    }

                                    else
                                      {

                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to create!');
                                      }



                                }

                                else
                                  {

                                     return redirect()
                                    ->route('online-policies')
                                    ->with('error','Policy failed to create!');
                                  }


          }

          else
          {

             return redirect()
            ->route('online-policies')
            ->with('error','Policy failed to create!');
          }
      }


      //Engineering Insurance

      if($request->input('policy_product')=='Engineering Insurance')
        {
    $time = explode(" - ", $request->input('insurance_period'));

        //$policynumberval = $this->generatePolicyNumber(10);
        //Policy Details
        $policy                         = new Policy;
        $policy->customer_number        = $request->input('customer_number');  
        $policy->policy_type            = $request->input('policy_type');
        $policy->policy_product         = $request->input('policy_product');
        $policy->policy_insurer         = $request->input('policy_insurer'); 
        $policy->insurance_period_from  = $this->change_date_format($time[0]);
        $policy->insurance_period_to    = $this->change_date_format($time[1]);
        $policy->policy_sales_type      = $request->input('policy_sales_type');
        $policy->policy_sales_channel   = $request->input('policy_sales_channel');
        $policy->policy_number          = $request->input('policy_number');
        $policy->ref_number             = $policyref;
        $policy->policy_currency        = $request->input('policy_currency');
        $policy->status                 = 'Pending Payment';
        $policy->approved_by            = Auth::user()->getNameOrUsername();
        $policy->created_by             = Auth::user()->getNameOrUsername();
        $policy->created_on             = Carbon::now();


        //Fire Details
        $engineering                                   = new EngineeringDetails;
        $engineering->car_risk_type                    = $request->input('car_risk_type');  
        $engineering->car_parties                      = $request->input('car_parties');
        $engineering->car_nature_of_business           = $request->input('car_nature_of_business');
        $engineering->car_contract_description         = $request->input('car_contract_description'); 
        $engineering->car_contract_sum                 = $request->input('car_contract_sum'); 
        $engineering->car_deductible                   = $request->input('car_deductible');
        $engineering->car_endorsements                 = $request->input('car_endorsements');
        $engineering->created_on                       = Carbon::now();
        $engineering->created_by                       = Auth::user()->getNameOrUsername();
        $engineering->ref_number                       = $policyref;

        //Invoice Generation

   
        $bill                               = new Bill;
        $bill->invoice_number               = $invoicenumberval;
        $bill->account_number               = $request->input('customer_number');
        $bill->account_name                 = $request->input('billed_to'); 
        $bill->policy_number                = $request->input('policy_number');
        $bill->policy_product               = $request->input('policy_product');
        $bill->currency                     = $request->input('policy_currency');
        $bill->amount                       = $request->input('gross_premium'); 
        $bill->commission_rate              = $request->input('commission_rate'); 
        $bill->note                         = $request->input('collection_mode'); 
        $bill->reference_number             = $policyref; 
        $bill->status                       = 'Unpaid';   
        $bill->paid_amount                  = 0; 
        $bill->created_by                   = Auth::user()->getNameOrUsername();
        $bill->created_on                   = Carbon::now();


         if($policy->save())
          {


                            if($engineering->save())  
                                { 


                                    if($bill->save())
                                    {                 
                                   Activity::log([
                                  'contentId'   =>  $request->input('account_number'),
                                  'contentType' => 'User',
                                  'action'      => 'Create',
                                  'description' => 'Policy '.$policynumberval.' - '.$request->input('billed_to').' was created successfully!',
                                  'details'     => 'Username: '.Auth::user()->getNameOrUsername(),
                                  ]);

                                    return redirect()
                                    ->route('invoice')
                                    ->with('success','Policy has successfully been created!');

                                    }

                                    else
                                      {

                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to create!');
                                      }



                                }

                                else
                                  {

                                     return redirect()
                                    ->route('online-policies')
                                    ->with('error','Policy failed to create!');
                                  }


          }

          else
          {

             return redirect()
            ->route('online-policies')
            ->with('error','Policy failed to create!');
          }
      }


        if($request->input('policy_product')=='Liability Insurance')
        {
    $time = explode(" - ", $request->input('insurance_period'));

        //$policynumberval = $this->generatePolicyNumber(10);
        //Policy Details
        $policy                         = new Policy;
        $policy->customer_number        = $request->input('customer_number');  
        $policy->policy_type            = $request->input('policy_type');
        $policy->policy_product         = $request->input('policy_product');
        $policy->policy_insurer         = $request->input('policy_insurer'); 
        $policy->insurance_period_from  = $this->change_date_format($time[0]);
        $policy->insurance_period_to    = $this->change_date_format($time[1]);
        $policy->policy_sales_type      = $request->input('policy_sales_type');
        $policy->policy_sales_channel   = $request->input('policy_sales_channel');
        $policy->policy_number          = $request->input('policy_number');
        $policy->ref_number             = $policyref;
        $policy->policy_currency        = $request->input('policy_currency');
        $policy->status                 = 'Pending Payment';
        $policy->approved_by            = Auth::user()->getNameOrUsername();
        $policy->created_by             = Auth::user()->getNameOrUsername();
        $policy->created_on             = Carbon::now();


        //Fire Details
        $liability                                   = new LiabilityDetails;
        $liability->liability_risk_type              = $request->input('liability_risk_type');  
        $liability->liability_schedule               = $request->input('liability_schedule');
        $liability->liability_beneficiary            = $request->input('liability_beneficiary');
        $liability->created_on                       = Carbon::now();
        $liability->created_by                       = Auth::user()->getNameOrUsername();
        $liability->ref_number                       = $policynumberval;

        //Invoice Generation

   
        $bill                               = new Bill;
        $bill->invoice_number               = $invoicenumberval;
        $bill->account_number               = $request->input('customer_number');
        $bill->account_name                 = $request->input('billed_to'); 
        $bill->policy_number                = $request->input('policy_number');
        $bill->policy_product               = $request->input('policy_product');
        $bill->currency                     = $request->input('policy_currency');
        $bill->amount                       = $request->input('gross_premium'); 
        $bill->commission_rate              = $request->input('commission_rate'); 
        $bill->note                         = $request->input('collection_mode'); 
        $bill->reference_number             = $policyref; 
        $bill->status                       = 'Unpaid';   
        $bill->paid_amount                  = 0; 
        $bill->created_by                   = Auth::user()->getNameOrUsername();
        $bill->created_on                   = Carbon::now();



         if($policy->save())
          {


                            if($liability->save())  
                                { 


                                    if($bill->save())
                                    {                 
                                   Activity::log([
                                  'contentId'   =>  $request->input('account_number'),
                                  'contentType' => 'User',
                                  'action'      => 'Create',
                                  'description' => 'Policy '.$policynumberval.' - '.$request->input('billed_to').' was created successfully!',
                                  'details'     => 'Username: '.Auth::user()->getNameOrUsername(),
                                  ]);

                                    return redirect()
                                    ->route('invoice')
                                    ->with('success','Policy has successfully been created!');

                                    }

                                    else
                                      {

                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to create!');
                                      }



                                }

                                else
                                  {

                                     return redirect()
                                    ->route('online-policies')
                                    ->with('error','Policy failed to create!');
                                  }


          }

          else
          {

             return redirect()
            ->route('online-policies')
            ->with('error','Policy failed to create!');
          }
      }


if($request->input('policy_product')=='Health Insurance')
        {
    $time = explode(" - ", $request->input('insurance_period'));

       
        $policy                         = new Policy;
        $policy->customer_number        = $request->input('customer_number');  
        $policy->policy_type            = $request->input('policy_type');
        $policy->policy_product         = $request->input('policy_product');
        $policy->policy_insurer         = $request->input('policy_insurer'); 
        $policy->insurance_period_from  = $this->change_date_format($time[0]);
        $policy->insurance_period_to    = $this->change_date_format($time[1]);
        $policy->policy_sales_type      = $request->input('policy_sales_type');
        $policy->policy_sales_channel   = $request->input('policy_sales_channel');
        $policy->policy_number          = $request->input('policy_number');
        $policy->ref_number             = $policyref;
        $policy->policy_currency        = $request->input('policy_currency');
        $policy->status                 = 'Pending Payment';
        $policy->approved_by            = Auth::user()->getNameOrUsername();
        $policy->created_by             = Auth::user()->getNameOrUsername();
        $policy->created_on             = Carbon::now();


        //health Details
        $health                                   = new HealthDetail;
        $health->health_type                      = $request->input('health_type');  
        $health->health_plan_details              = $request->input('health_plan_details');
        $health->health_plan_limits               = $request->input('health_plan_limits');
        $health->created_on                       = Carbon::now();
        $health->created_by                       = Auth::user()->getNameOrUsername();
        $health->ref_number                       = $policyref;

        //Invoice Generation

   
        $bill                               = new Bill;
        $bill->invoice_number               = $invoicenumberval;
        $bill->account_number               = $request->input('customer_number');
        $bill->account_name                 = $request->input('billed_to'); 
        $bill->policy_number                = $request->input('policy_number');
        $bill->policy_product               = $request->input('policy_product');
        $bill->currency                     = $request->input('policy_currency');
        $bill->amount                       = $request->input('gross_premium'); 
        $bill->commission_rate              = $request->input('commission_rate'); 
        $bill->note                         = $request->input('collection_mode'); 
        $bill->reference_number             = $policyref; 
        $bill->status                       = 'Unpaid';   
        $bill->paid_amount                  = 0; 
        $bill->created_by                   = Auth::user()->getNameOrUsername();
        $bill->created_on                   = Carbon::now();



         if($policy->save())
          {


                            if($health->save())  
                                { 


                                    if($bill->save())
                                    {                 
                                   Activity::log([
                                  'contentId'   =>  $request->input('account_number'),
                                  'contentType' => 'User',
                                  'action'      => 'Create',
                                  'description' => 'Policy '.$policynumberval.' - '.$request->input('billed_to').' was created successfully!',
                                  'details'     => 'Username: '.Auth::user()->getNameOrUsername(),
                                  ]);


                                   
                                    return redirect()
                                    ->route('invoice')
                                    ->with('success','Policy has successfully been created!');

                                    }

                                    else
                                      {

                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to create!');
                                      }



                                }

                                else
                                  {

                                     return redirect()
                                    ->route('online-policies')
                                    ->with('error','Policy failed to create!');
                                  }


          }

          else
          {

             return redirect()
            ->route('online-policies')
            ->with('error','Policy failed to create!');
          }
      }



if($request->input('policy_product')=='Life Insurance')
        {
    $time = explode(" - ", $request->input('insurance_period'));

        //$policynumberval = $this->generatePolicyNumber(10);
        //Policy Details
        $policy                         = new Policy;
        $policy->customer_number        = $request->input('customer_number');  
        $policy->policy_type            = $request->input('policy_type');
        $policy->policy_product         = $request->input('policy_product');
        $policy->policy_insurer         = $request->input('policy_insurer'); 
        $policy->insurance_period_from  = $this->change_date_format($time[0]);
        $policy->insurance_period_to    = $this->change_date_format($time[1]);
        $policy->policy_sales_type      = $request->input('policy_sales_type');
        $policy->policy_sales_channel   = $request->input('policy_sales_channel');
        $policy->policy_number          = $request->input('policy_number');
        $policy->ref_number             = $policyref;
        $policy->policy_currency        = $request->input('policy_currency');
        $policy->status                 = 'Pending Payment';
        $policy->approved_by            = Auth::user()->getNameOrUsername();
        $policy->created_by             = Auth::user()->getNameOrUsername();
        $policy->created_on             = Carbon::now();


        //Fire Details
        $lifeplan                                  = new LifeDetail;
        $lifeplan->life_type                       = $request->input('life_type');  
        $lifeplan->life_cover_amount               = $request->input('life_cover_amount');
        $lifeplan->life_monthly_premium            = $request->input('life_monthly_premium');
        $lifeplan->life_plan_details               = $request->input('life_plan_details');
        $lifeplan->life_plan_limits                = $request->input('life_plan_limits');
        $lifeplan->created_on                       = Carbon::now();
        $lifeplan->created_by                       = Auth::user()->getNameOrUsername();
        $lifeplan->ref_number                       = $policyref;

        //Invoice Generation

   
        $bill                               = new Bill;
        $bill->invoice_number               = $invoicenumberval;
        $bill->account_number               = $request->input('customer_number');
        $bill->account_name                 = $request->input('billed_to'); 
        $bill->policy_number                = $request->input('policy_number');
        $bill->policy_product               = $request->input('policy_product');
        $bill->currency                     = $request->input('policy_currency');
        $bill->amount                       = $request->input('gross_premium'); 
        $bill->commission_rate              = $request->input('commission_rate'); 
        $bill->note                         = $request->input('collection_mode'); 
        $bill->reference_number             = $policyref; 
        $bill->status                       = 'Unpaid';   
        $bill->paid_amount                  = 0; 
        $bill->created_by                   = Auth::user()->getNameOrUsername();
        $bill->created_on                   = Carbon::now();


         if($policy->save())
          {


                            if($lifeplan->save())  
                                { 


                                    if($bill->save())
                                    {                 
                                   Activity::log([
                                  'contentId'   =>  $request->input('account_number'),
                                  'contentType' => 'User',
                                  'action'      => 'Create',
                                  'description' => 'Policy '.$policynumberval.' - '.$request->input('billed_to').' was created successfully!',
                                  'details'     => 'Username: '.Auth::user()->getNameOrUsername(),
                                  ]);

                                
                                    return redirect()
                                    ->route('invoice')
                                    ->with('success','Policy has successfully been created!');

                                    }

                                    else
                                      {

                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to create!');
                                      }



                                }

                                else
                                  {

                                     return redirect()
                                    ->route('online-policies')
                                    ->with('error','Policy failed to create!');
                                  }


          }

          else
          {

             return redirect()
            ->route('online-policies')
            ->with('error','Policy failed to create!');
          }
      }



//Bond Insurance

if($request->input('policy_product')=='Bond Insurance')
        {
    $time = explode(" - ", $request->input('insurance_period'));

        //$policynumberval = $this->generatePolicyNumber(10);
        //Policy Details
        $policy                         = new Policy;
        $policy->customer_number        = $request->input('customer_number');  
        $policy->policy_type            = $request->input('policy_type');
        $policy->policy_product         = $request->input('policy_product');
        $policy->policy_insurer         = $request->input('policy_insurer'); 
        $policy->insurance_period_from  = $this->change_date_format($time[0]);
        $policy->insurance_period_to    = $this->change_date_format($time[1]);
        $policy->policy_sales_type      = $request->input('policy_sales_type');
        $policy->policy_sales_channel   = $request->input('policy_sales_channel');
        $policy->policy_number          = $request->input('policy_number');
        $policy->ref_number             = $policyref;
        $policy->policy_currency        = $request->input('policy_currency');
        $policy->status                 = 'Pending Payment';
        $policy->approved_by            = Auth::user()->getNameOrUsername();
        $policy->created_by             = Auth::user()->getNameOrUsername();
        $policy->created_on             = Carbon::now();


        //Fire Details
        $bond                                   = new BondDetails;
        $bond->bond_risk_type                   = $request->input('bond_risk_type');  
        $bond->bond_interest                    = $request->input('bond_interest');
        $bond->bond_interest_address            = $request->input('bond_interest_address');
        $bond->contract_sum                     = $request->input('contract_sum'); 
        $bond->bond_sum_insured                 = $request->input('bond_sum_insured'); 
        $bond->bond_contract_description        = $request->input('bond_contract_description');
        $bond->created_on                       = Carbon::now();
        $bond->created_by                       = Auth::user()->getNameOrUsername();
        $bond->ref_number                       = $policyref;

        //Invoice Generation

   
        $bill                               = new Bill;
        $bill->invoice_number               = $invoicenumberval;
        $bill->account_number               = $request->input('customer_number');
        $bill->account_name                 = $request->input('billed_to'); 
        $bill->policy_number                = $request->input('policy_number');
        $bill->policy_product               = $request->input('policy_product');
        $bill->currency                     = $request->input('policy_currency');
        $bill->amount                       = $request->input('gross_premium'); 
        $bill->commission_rate              = $request->input('commission_rate'); 
        $bill->note                         = $request->input('collection_mode'); 
        $bill->reference_number             = $policyref; 
        $bill->status                       = 'Unpaid';   
        $bill->paid_amount                  = 0; 
        $bill->created_by                   = Auth::user()->getNameOrUsername();
        $bill->created_on                   = Carbon::now();



         if($policy->save())
          {


                            if($bond->save())  
                                { 


                                    if($bill->save())
                                    {                 
                                   Activity::log([
                                  'contentId'   =>  $request->input('account_number'),
                                  'contentType' => 'User',
                                  'action'      => 'Create',
                                  'description' => 'Policy '.$policynumberval.' - '.$request->input('billed_to').' was created successfully!',
                                  'details'     => 'Username: '.Auth::user()->getNameOrUsername(),
                                  ]);


                                   
                                    return redirect()
                                    ->route('invoice')
                                    ->with('success','Policy has successfully been created!');

                                    }

                                    else
                                      {

                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to create!');
                                      }



                                }

                                else
                                  {

                                     return redirect()
                                    ->route('online-policies')
                                    ->with('error','Policy failed to create!');
                                  }


          }

          else
          {

             return redirect()
            ->route('online-policies')
            ->with('error','Policy failed to create!');
          }
      }
    

//General Accident
if($request->input('policy_product')=='General Accident Insurance')
        {
    $time = explode(" - ", $request->input('insurance_period'));

        //$policynumberval = $this->generatePolicyNumber(10);
        //Policy Details
        $policy                         = new Policy;
        $policy->customer_number        = $request->input('customer_number');  
        $policy->policy_type            = $request->input('policy_type');
        $policy->policy_product         = $request->input('policy_product');
        $policy->policy_insurer         = $request->input('policy_insurer'); 
        $policy->insurance_period_from  = $this->change_date_format($time[0]);
        $policy->insurance_period_to    = $this->change_date_format($time[1]);
        $policy->policy_sales_type      = $request->input('policy_sales_type');
        $policy->policy_sales_channel   = $request->input('policy_sales_channel');
        $policy->policy_number          = $policynumberval;
        $policy->ref_number             = $policyref;
        $policy->policy_currency        = $request->input('policy_currency');
        $policy->status                 = 'Pending Payment';
        $policy->approved_by            = Auth::user()->getNameOrUsername();
        $policy->created_by             = Auth::user()->getNameOrUsername();
        $policy->created_on             = Carbon::now();


        //General Accident Details
        $accident                                   = new AccidentDetails;
        $accident->accident_risk_type               = $request->input('accident_risk_type');  
        $accident->general_accident_sum_insured     = $request->input('general_accident_sum_insured');
        $accident->general_accident_deductible      = $request->input('general_accident_deductible');
        $accident->accident_description             = $request->input('accident_description'); 
        $accident->accident_beneficiaries           = $request->input('accident_beneficiaries'); 
        $accident->accident_clause_limit            = $request->input('accident_clause_limit');
        $accident->created_on                       = Carbon::now();
        $accident->created_by                       = Auth::user()->getNameOrUsername();
        $accident->ref_number                       = $policyref;

        //Invoice Generation

   
        $bill                               = new Bill;
        $bill->invoice_number               = $invoicenumberval;
        $bill->account_number               = $request->input('customer_number');
        $bill->account_name                 = $request->input('billed_to'); 
        $bill->policy_number                = $request->input('policy_number');
        $bill->policy_product               = $request->input('policy_product');
        $bill->currency                     = $request->input('policy_currency');
        $bill->amount                       = $request->input('gross_premium'); 
        $bill->commission_rate              = $request->input('commission_rate'); 
        $bill->note                         = $request->input('collection_mode'); 
        $bill->reference_number             = $policyref; 
        $bill->status                       = 'Unpaid';   
        $bill->paid_amount                  = 0; 
        $bill->created_by                   = Auth::user()->getNameOrUsername();
        $bill->created_on                   = Carbon::now();


         if($policy->save())
          {


                            if($accident->save())  
                                { 


                                    if($bill->save())
                                    {                 
                                   Activity::log([
                                  'contentId'   =>  $request->input('account_number'),
                                  'contentType' => 'User',
                                  'action'      => 'Create',
                                  'description' => 'Policy '.$policynumberval.' - '.$request->input('billed_to').' was created successfully!',
                                  'details'     => 'Username: '.Auth::user()->getNameOrUsername(),
                                  ]);
                                
                                    return redirect()
                                    ->route('invoice')
                                    ->with('success','Policy has successfully been created!');

                                    }

                                    else
                                      {

                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to create!');
                                      }



                                }

                                else
                                  {

                                     return redirect()
                                    ->route('online-policies')
                                    ->with('error','Policy failed to create!');
                                  }


          }

          else
          {

             return redirect()
            ->route('online-policies')
            ->with('error','Policy failed to create!');
          }
      }


// Travel Poloicy

    if($request->input('policy_product')=='Travel Insurance')
        {
        $time = explode(" - ", $request->input('insurance_period'));


        //dd($request->input('destination_country'));
        //dd(implode($request->input('destination_country'), ', '));
        //$policynumberval = $this->generatePolicyNumber(10);
        //Policy Details
        $policy                         = new Policy;
        $policy->customer_number        = $request->input('customer_number');  
        $policy->policy_type            = $request->input('policy_type');
        $policy->policy_product         = $request->input('policy_product');
        $policy->policy_insurer         = $request->input('policy_insurer'); 
        $policy->insurance_period_from  = $this->change_date_format($time[0]);
        $policy->insurance_period_to    = $this->change_date_format($time[1]);
        $policy->policy_sales_type      = $request->input('policy_sales_type');
        $policy->policy_sales_channel   = $request->input('policy_sales_channel');
        $policy->policy_number          = $request->input('policy_number');
        $policy->policy_currency        = $request->input('policy_currency');
        $policy->ref_number             = $policyref;
        $policy->status                 = 'Pending Payment';
        $policy->approved_by            = Auth::user()->getNameOrUsername();
        $policy->created_by             = Auth::user()->getNameOrUsername();
        $policy->created_on             = Carbon::now();


        //Travel Details
        $travel                              = new TravelDetails;
        $travel->destination_country         = implode($request->input('destination_country'), ', ');
        $travel->departure_date              = Carbon::createFromFormat('d/m/Y', $request->input('departure_date'));
        $travel->arrival_date                = Carbon::createFromFormat('d/m/Y', $request->input('arrival_date'));
        $travel->passport_number             = $request->input('passport_number'); 
        $travel->issuing_country             = $request->input('issuing_country'); 
        $travel->citizenship                 = $request->input('citizenship');
        $travel->beneficiary_name            = $request->input('beneficiary_name');
        $travel->beneficiary_relationship    = $request->input('beneficiary_relationship');
        $travel->beneficiary_contact         = $request->input('beneficiary_contact');
        $travel->travel_reason               = $request->input('travel_reason');
        $travel->ref_number                  = $policyref; 

        //Invoice Generation

   
        $bill                               = new Bill;
        $bill->invoice_number               = $invoicenumberval;
        $bill->account_number               = $request->input('customer_number');
        $bill->account_name                 = $request->input('billed_to'); 
        $bill->policy_number                = $request->input('policy_number');
        $bill->policy_product               = $request->input('policy_product');
        $bill->currency                     = $request->input('policy_currency');
        $bill->amount                       = $request->input('gross_premium'); 
        $bill->commission_rate              = $request->input('commission_rate'); 
        $bill->note                         = $request->input('collection_mode'); 
        $bill->reference_number             = $policyref; 
        $bill->status                       = 'Unpaid';   
        $bill->paid_amount                  = 0; 
        $bill->created_by                   = Auth::user()->getNameOrUsername();
        $bill->created_on                   = Carbon::now();


         if($policy->save())
          {


                            if($travel->save())  
                                { 


                                    if($bill->save())
                                    {                 
                                   Activity::log([
                                  'contentId'   =>  $request->input('account_number'),
                                  'contentType' => 'User',
                                  'action'      => 'Create',
                                  'description' => 'Policy '.$policynumberval.' - '.$request->input('billed_to').' was created successfully!',
                                  'details'     => 'Username: '.Auth::user()->getNameOrUsername(),
                                  ]);

                                
                                    return redirect()
                                    ->route('invoice')
                                    ->with('success','Policy has successfully been created!');

                                    }

                                    else
                                      {

                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to create!');
                                      }



                                }

                                else
                                  {

                                     return redirect()
                                    ->route('online-policies')
                                    ->with('error','Policy failed to create!');
                                  }


          }

          else
          {

             return redirect()
            ->route('online-policies')
            ->with('error','Policy failed to create!');
          }
      }


      if($request->input('policy_product')=='Personal Accident Insurance')

        {
        
        $time = explode(" - ", $request->input('insurance_period'));

        //$policynumberval = $this->generatePolicyNumber(10);
        //Policy Details
        $policy                         = new Policy;
        $policy->customer_number        = $request->input('customer_number');  
        $policy->policy_type            = $request->input('policy_type');
        $policy->policy_product         = $request->input('policy_product');
        $policy->policy_insurer         = $request->input('policy_insurer'); 
        $policy->insurance_period_from  = $this->change_date_format($time[0]);
        $policy->insurance_period_to    = $this->change_date_format($time[1]);
        $policy->policy_sales_type      = $request->input('policy_sales_type');
        $policy->policy_sales_channel   = $request->input('policy_sales_channel');
        $policy->policy_number          = $request->input('policy_number');
        $policy->ref_number             = $policyref;
        $policy->policy_currency        = $request->input('policy_currency');
        $policy->status                 = 'Pending Payment';
        $policy->approved_by            = Auth::user()->getNameOrUsername();
        $policy->created_by             = Auth::user()->getNameOrUsername();
        $policy->created_on             = Carbon::now();


        //PA Details
        $accident                                   = new Accident;
        $accident->pa_sum_insured                   = $request->input('pa_sum_insured');  
        $accident->pa_height                        = $request->input('pa_height');
        $accident->pa_weight                        = $request->input('pa_weight');
        $accident->marital_status                   = $request->input('marital_status'); 
        $accident->nature_of_work                   = $request->input('nature_of_work'); 
        $accident->pa_accident_received             = $request->input('pa_accident_received');
        $accident->pa_nature_of_accident            = $request->input('pa_nature_of_accident');
        $accident->accident_duration                = $request->input('accident_duration');
        $accident->accident_period                  = $request->input('accident_period');
        $accident->pa_activities                    = $request->input('pa_activities');
        $accident->pa_special_term_status           = $request->input('pa_special_term_status');
        $accident->pa_cancelled_insurance_status    = $request->input('pa_cancelled_insurance_status');
        $accident->pa_increased_premium_status      = $request->input('pa_increased_premium_status');
        $accident->pa_benefit_details               = $request->input('pa_benefit_details');
        $accident->ref_number                       = $policyref; 

        //Invoice Generation

   
        $bill                               = new Bill;
        $bill->invoice_number               = $invoicenumberval;
        $bill->account_number               = $request->input('customer_number');
        $bill->account_name                 = $request->input('billed_to'); 
        $bill->policy_number                = $request->input('policy_number');
        $bill->policy_product               = $request->input('policy_product');
        $bill->currency                     = $request->input('policy_currency');
        $bill->amount                       = $request->input('gross_premium'); 
        $bill->commission_rate              = $request->input('commission_rate'); 
        $bill->note                         = $request->input('collection_mode'); 
        $bill->reference_number             = $policyref; 
        $bill->status                       = 'Unpaid';   
        $bill->paid_amount                  = 0; 
        $bill->created_by                   = Auth::user()->getNameOrUsername();
        $bill->created_on                   = Carbon::now();


         if($policy->save())
          {


                            if($accident->save())  
                                { 


                                    if($bill->save())
                                    {                 
                                   Activity::log([
                                  'contentId'   =>  $request->input('account_number'),
                                  'contentType' => 'User',
                                  'action'      => 'Create',
                                  'description' => 'Policy '.$policynumberval.' - '.$request->input('billed_to').' was created successfully!',
                                  'details'     => 'Username: '.Auth::user()->getNameOrUsername(),
                                  ]);


                                
                                    return redirect()
                                    ->route('invoice')
                                    ->with('success','Policy has successfully been created!');

                                    }

                                    else
                                      {

                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to create!');
                                      }



                                }

                                else
                                  {

                                     return redirect()
                                    ->route('online-policies')
                                    ->with('error','Policy failed to create!');
                                  }


          }

          else
          {

             return redirect()
            ->route('online-policies')
            ->with('error','Policy failed to create!');
          }
      }

      else
          {

             return redirect()
            ->route('online-policies')
            ->with('error','Policy failed to create!');
          }

    
}




public function updatePolicy(Request $request)
{

             
       //dd(Input::get('detailid'));

        if($request->input('policy_product')=='Motor Insurance')
        {
        

        $time = explode(" - ", $request->input('insurance_period'));


         $affectedRows = Policy::where('id', $request->input('policyid'))
            ->update(array(

                           'policy_insurer' =>  $request->input('policy_insurer'),
                           'policy_number' =>  $request->input('policy_number'),
                           'policy_currency' =>  $request->input('policy_currency'),
                           'insurance_period_from' => $this->change_date_format($time[0]), 
                           'insurance_period_to' =>$this->change_date_format($time[1])));

            if($affectedRows > 0)
            {
                $affected = MotorDetails::where('id',$request->input('detailid'))
            ->update(array(
                           
                           'preferedcover'              =>  $request->input('preferedcover'),
                           'vehicle_currency'           =>  $request->input('vehicle_currency'),
                           'vehicle_value'              =>  $request->input('vehicle_value'),
                           'vehicle_buy_back_excess'    =>  $request->input('vehicle_buy_back_excess'),
                           'vehicle_tppdl_standard'     =>  $request->input('vehicle_tppdl_standard'),
                           'vehicle_tppdl_value'        =>  $request->input('vehicle_tppdl_value'),
                           'vehicle_body_type'          =>  $request->input('vehicle_body_type'),
                           'vehicle_model'              =>  $request->input('vehicle_model'),
                           'vehicle_make'               =>  $request->input('vehicle_make'),
                           'vehicle_use'                =>  $request->input('vehicle_use'),
                           'vehicle_make_year'          =>  $request->input('vehicle_make_year'),
                           'vehicle_seating_capacity'   =>  $request->input('vehicle_seating_capacity'),
                           'vehicle_cubic_capacity'     =>  $request->input('vehicle_cubic_capacity'),
                           'vehicle_registration_number' =>  $request->input('vehicle_registration_number'),
                           'vehicle_chassis_number'     =>  $request->input('vehicle_chassis_number'),
                           'vehicle_interest_status'    =>  $request->input('vehicle_interest_status'),
                           'vehicle_interest_name'      =>  $request->input('vehicle_interest_name'),

                           'vehicle_declined_status'    =>  $request->input('vehicle_declined_status'),
                           'vehicle_declined_reason'    =>  $request->input('vehicle_declined_reason'),
                           'vehicle_cancelled_status'   =>  $request->input('vehicle_cancelled_status'),
                           'vehicle_cancelled_reason'   =>  $request->input('vehicle_cancelled_reason'),

                           'vehicle_risk'               =>  $request->input('vehicle_risk'),
                           'vehicle_ncd'                =>  $request->input('vehicle_ncd'),
                           'vehicle_fleet_discount'     =>  $request->input('vehicle_fleet_discount')));

                          
                        if($affected > 0)
                        {
                            return redirect()
                                        ->route('online-policies')
                                        ->with('success','Policy updated successfully!');

                        }

                        else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }
            
                }
                else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }
        
        

      
        }

  //Fire Policy
   
 if($request->input('policy_product')=='Fire Insurance')
        {
   
             $time = explode(" - ", $request->input('insurance_period'));


         $affectedRows = Policy::where('id', $request->input('policyid'))
            ->update(array(

                           'policy_insurer' =>  $request->input('policy_insurer'),
                           'policy_number' =>  $request->input('policy_number'),
                           'policy_currency' =>  $request->input('policy_currency'),
                           'insurance_period_from' => $this->change_date_format($time[0]), 
                           'insurance_period_to' =>$this->change_date_format($time[1])));

            if($affectedRows > 0)
            {
                $affected = FireDetails::where('id',$request->input('detailid'))
            ->update(array(
                           
                           'fire_risk_covered'              =>  $request->input('fire_risk_covered'),
                           'fire_building_cost'             =>  $request->input('fire_building_cost'),
                           'fire_deductible'                =>  $request->input('fire_deductible'),
                           'fire_personal_property_coverage'=>  $request->input('fire_personal_property_coverage'),
                           'fire_temporary_rental_cost'     =>  $request->input('fire_temporary_rental_cost'),
                           'fire_building_address'          =>  $request->input('fire_building_address'),
                           'fire_property_type'             =>  $request->input('fire_property_type'),
                           'walled_with'                    =>  $request->input('walled_with'),
                           'roofed_with'                    =>  $request->input('roofed_with'),
                           'fire_mortgage_status'           =>  $request->input('fire_mortgage_status'),
                           'fire_mortgage_company'          =>  $request->input('fire_mortgage_company'),
                           'property_content'               =>  $request->input('property_content')));

                          
                        if($affected > 0)
                        {
                            return redirect()
                                        ->route('online-policies')
                                        ->with('success','Policy updated successfully!');

                        }

                        else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }
            
                }
                else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }   

      }
    
//Marine Insurance

if($request->input('policy_product')=='Marine Insurance')
        {
    


         $time = explode(" - ", $request->input('insurance_period'));
         $affectedRows = Policy::where('id', $request->input('policyid'))
            ->update(array(

                           'policy_insurer' =>  $request->input('policy_insurer'),
                           'policy_number' =>  $request->input('policy_number'),
                           'policy_currency' =>  $request->input('policy_currency'),
                           'insurance_period_from' => $this->change_date_format($time[0]), 
                           'insurance_period_to' =>$this->change_date_format($time[1])));

            if($affectedRows > 0)
            {
                $affected = FireDetails::where('id',$request->input('detailid'))
            ->update(array(
                           
                           'marine_risk_type'           =>  $request->input('marine_risk_type'),
                           'marine_sum_insured'         =>  $request->input('marine_sum_insured'),
                           'marine_bill_landing'        =>  $request->input('marine_bill_landing'),
                           'marine_interest'            =>  $request->input('marine_interest'),
                           'marine_vessel'              =>  $request->input('marine_vessel'),
                           'marine_insurance_condition' =>  $request->input('marine_insurance_condition'),
                           'marine_valuation'           =>  $request->input('marine_valuation'),
                           'marine_means_of_conveyance' =>  $request->input('marine_means_of_conveyance'),
                           'marine_voyage'              =>  $request->input('marine_voyage'),
                           'marine_condition'           =>  $request->input('marine_condition')));

                          
                        if($affected > 0)
                        {
                            return redirect()
                                        ->route('online-policies')
                                        ->with('success','Policy updated successfully!');

                        }

                        else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }
            
                }
                else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }   

   
      }


      //Engineering Insurance

if($request->input('policy_product')=='Engineering Insurance')
{
        
       
         $time = explode(" - ", $request->input('insurance_period'));
         $affectedRows = Policy::where('id', $request->input('policyid'))
            ->update(array(

                           'policy_insurer' =>  $request->input('policy_insurer'),
                           'policy_number' =>  $request->input('policy_number'),
                           'policy_currency' =>  $request->input('policy_currency'),
                           'insurance_period_from' => $this->change_date_format($time[0]), 
                           'insurance_period_to' =>$this->change_date_format($time[1])));

            if($affectedRows > 0)
            {
                $affected = EngineeringDetails::where('id',$request->input('detailid'))
            ->update(array(
                           
                           'car_risk_type'           =>  $request->input('car_risk_type'),
                           'car_parties'             =>  $request->input('car_parties'),
                           'car_nature_of_business'  =>  $request->input('car_nature_of_business'),
                           'car_contract_description'=>  $request->input('car_contract_description'),
                           'car_contract_sum'        =>  $request->input('car_contract_sum'),
                           'car_deductible'          =>  $request->input('car_deductible'),
                           'car_endorsements'        =>  $request->input('car_endorsements')));

                          
                        if($affected > 0)
                        {
                            return redirect()
                                        ->route('online-policies')
                                        ->with('success','Policy updated successfully!');

                        }

                        else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }
            
                }
                else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }   
       
}


if($request->input('policy_product')=='Liability Insurance')
{
        
        $time = explode(" - ", $request->input('insurance_period'));
        $affectedRows = Policy::where('id', $request->input('policyid'))
            ->update(array(

                           'policy_insurer' =>  $request->input('policy_insurer'),
                           'policy_number' =>  $request->input('policy_number'),
                           'policy_currency' =>  $request->input('policy_currency'),
                           'insurance_period_from' => $this->change_date_format($time[0]), 
                           'insurance_period_to' =>$this->change_date_format($time[1])));

            if($affectedRows > 0)
            {
                $affected = LiabilityDetails::where('id',$request->input('detailid'))
            ->update(array(
                           
                           'liability_risk_type'        =>  $request->input('liability_risk_type'),
                           'liability_schedule'         =>  $request->input('liability_schedule'),
                           'liability_schedule'         =>  $request->input('liability_schedule'),
                           'liability_beneficiary'      =>  $request->input('liability_beneficiary')));

                          
                        if($affected > 0)
                        {
                            return redirect()
                                        ->route('online-policies')
                                        ->with('success','Policy updated successfully!');

                        }

                        else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }
            
                }
                else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }   
        
     
}


if($request->input('policy_product')=='Health Insurance')
        {
    
        $time = explode(" - ", $request->input('insurance_period'));
        $affectedRows = Policy::where('id', $request->input('policyid'))
            ->update(array(

                           'policy_insurer'        =>   $request->input('policy_insurer'),
                           'policy_number' =>  $request->input('policy_number'),
                           'policy_currency' =>  $request->input('policy_currency'),
                           'insurance_period_from' =>   $this->change_date_format($time[0]), 
                           'insurance_period_to'   =>   $this->change_date_format($time[1])));

            if($affectedRows > 0)
            {
                $affected = HealthDetail::where('id',$request->input('detailid'))
            ->update(array(
                           
                           'health_type'            =>  $request->input('health_type'),
                           'health_plan_details'    =>  $request->input('health_plan_details'),
                           'health_plan_limits'     =>  $request->input('health_plan_limits')));

                          
                        if($affected > 0)
                        {
                            return redirect()
                                        ->route('online-policies')
                                        ->with('success','Policy updated successfully!');

                        }

                        else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }
            
                }
                else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }
     
      }



if($request->input('policy_product')=='Life Insurance')
    {
    
        $time = explode(" - ", $request->input('insurance_period'));
        $affectedRows = Policy::where('id', $request->input('policyid'))
            ->update(array(

                           'policy_insurer'         => $request->input('policy_insurer'),
                           'policy_number' =>  $request->input('policy_number'),
                           'policy_currency' =>  $request->input('policy_currency'),
                           'insurance_period_from'  => $this->change_date_format($time[0]), 
                           'insurance_period_to'    => $this->change_date_format($time[1])));

            if($affectedRows > 0)
            {
                $affected = LifeDetail::where('id',$request->input('detailid'))
            ->update(array(
                           
                           'life_type'              =>  $request->input('life_type'),
                           'life_cover_amount'      =>  $request->input('life_cover_amount'),
                           'life_monthly_premium'   =>  $request->input('life_monthly_premium'),
                           'life_plan_details'      =>  $request->input('life_plan_details'),
                           'life_plan_limits'       =>  $request->input('life_plan_limits')));

                          
                        if($affected > 0)
                        {
                            return redirect()
                                        ->route('online-policies')
                                        ->with('success','Policy updated successfully!');

                        }

                        else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }
            
            }
            else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }
   

    }



//Bond Insurance

if($request->input('policy_product')=='Bond Insurance')
        {

            //dd($request->input('policyid'));
        $time = explode(" - ", $request->input('insurance_period'));
        $affectedRows = Policy::where('id','=', $request->input('policyid'))
            ->update(array(

                           'policy_insurer'         => $request->input('policy_insurer'),
                           'policy_number'          => $request->input('policy_number'),
                           'policy_currency'        => $request->input('policy_currency'),
                           'insurance_period_from'  => $this->change_date_format($time[0]), 
                           'insurance_period_to'    => $this->change_date_format($time[1])));

            if($affectedRows > 0)
            {
                $affected = BondDetails::where('id',$request->input('detailid'))
            ->update(array(
                           
                           'bond_risk_type'                 => $request->input('bond_risk_type'),
                           'bond_interest'                  => $request->input('bond_interest'),
                           'bond_interest_address'          => $request->input('bond_interest_address'),
                           'contract_sum'                   => $request->input('contract_sum'),
                           'bond_sum_insured'               => $request->input('bond_sum_insured'),
                           'bond_contract_description'      => $request->input('bond_contract_description')));

                          
                        if($affected > 0)
                        {
                            return redirect()
                                        ->route('online-policies')
                                        ->with('success','Policy updated successfully!');

                        }

                        else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','2. Policy failed to update!');
                        }
            
            }
             else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','1. Policy failed to update!');
                        }

       
      }
    

//General Accident
if($request->input('policy_product')=='General Accident Insurance')
    {
        
            $time = explode(" - ", $request->input('insurance_period'));
            $affectedRows = Policy::where('id', $request->input('policyid'))
            ->update(array(

                           'policy_insurer'         => $request->input('policy_insurer'),
                           'policy_number' =>  $request->input('policy_number'),
                           'policy_currency' =>  $request->input('policy_currency'),
                           'insurance_period_from'  => $this->change_date_format($time[0]), 
                           'insurance_period_to'    => $this->change_date_format($time[1])));

            if($affectedRows > 0)
            {
                $affected = AccidentDetails::where('id',$request->input('detailid'))
            ->update(array(
                           
                           'accident_risk_type'             =>  $request->input('accident_risk_type'),
                           'general_accident_sum_insured'   =>  $request->input('general_accident_sum_insured'),
                           'general_accident_deductible'    =>  $request->input('general_accident_deductible'),
                           'accident_description'           =>  $request->input('accident_description'),
                           'accident_beneficiaries'         =>  $request->input('accident_beneficiaries'),
                           'accident_clause_limit'          =>  $request->input('accident_clause_limit')));

                          
                        if($affected > 0)
                        {
                            return redirect()
                                        ->route('online-policies')
                                        ->with('success','Policy updated successfully!');

                        }

                        else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }
            
            }
             else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }
    }


// Travel Poloicy

    if($request->input('policy_product')=='Travel Insurance')
    {
    
            $time = explode(" - ", $request->input('insurance_period'));
            $affectedRows = Policy::where('id', $request->input('policyid'))
            ->update(array(

                           'policy_insurer'         => $request->input('policy_insurer'),
                           'policy_number' =>  $request->input('policy_number'),
                           'policy_currency' =>  $request->input('policy_currency'),
                           'insurance_period_from'  => $this->change_date_format($time[0]), 
                           'insurance_period_to'    => $this->change_date_format($time[1])));

            if($affectedRows > 0)
            {
                $affected = TravelDetails::where('id',$request->input('detailid'))
            ->update(array(
                           
                           'destination_country'             =>  implode($request->input('destination_country'), ', '),
                           'departure_date'                  =>  $request->input('departure_date'),
                           'arrival_date'                    =>  $request->input('arrival_date'),
                           'passport_number'                 =>  $request->input('passport_number'),
                           'issuing_country'                 =>  $request->input('issuing_country'),
                           'citizenship'                     =>  $request->input('citizenship'),
                           'beneficiary_name'                =>  $request->input('beneficiary_name'),
                           'beneficiary_relationship'        =>  $request->input('beneficiary_relationship'),
                           'beneficiary_contact'             =>  $request->input('beneficiary_contact'),
                           'travel_reason'                   =>  $request->input('travel_reason')));

                          
                        if($affected > 0)
                        {
                            return redirect()
                                        ->route('online-policies')
                                        ->with('success','Policy updated successfully!');

                        }

                        else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }
            
            }
            else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }
        
      }


      if($request->input('policy_product')=='Personal Accident Insurance')

        {
        
        $time = explode(" - ", $request->input('insurance_period'));
            $affectedRows = Policy::where('id', $request->input('policyid'))
            ->update(array(

                           'policy_insurer'         => $request->input('policy_insurer'),
                           'policy_number' =>  $request->input('policy_number'),
                           'policy_currency'        =>  $request->input('policy_currency'),
                           'insurance_period_from'  => $this->change_date_format($time[0]), 
                           'insurance_period_to'    => $this->change_date_format($time[1])));

            if($affectedRows > 0)
            {
                $affected = Accident::where('id',$request->input('detailid'))
            ->update(array(
                           
                           'pa_sum_insured'             =>  $request->input('pa_sum_insured'),
                           'pa_height'                  =>  $request->input('pa_height'),
                           'pa_weight'                  =>  $request->input('pa_weight'),
                           'marital_status'             =>  $request->input('marital_status'),
                           'nature_of_work'             =>  $request->input('nature_of_work'),
                           'pa_accident_received'       =>  $request->input('pa_accident_received'),
                           'pa_nature_of_accident'      =>  $request->input('pa_nature_of_accident'),
                           'accident_duration'          =>  $request->input('accident_duration'),
                           'accident_period'            =>  $request->input('accident_period'),
                           'pa_activities'              =>  $request->input('pa_activities'),
                           'pa_special_term_status'     =>  $request->input('pa_special_term_status'),
                           'pa_cancelled_insurance_status' =>  $request->input('pa_cancelled_insurance_status'),
                           'pa_increased_premium_status'   =>  $request->input('pa_increased_premium_status'),
                           'pa_benefit_details'            =>  $request->input('pa_benefit_details')));

                          
                        if($affected > 0)
                        {
                            return redirect()
                                        ->route('online-policies')
                                        ->with('success','Policy updated successfully!');

                        }

                        else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }
            
            }
            else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }
       
       

        }



}


public function renewPolicy(Request $request)
{


        $invoicenumberval = $this->generateInoviceNumber(10);
        $policyref = $request->input('refid');

        if($request->input('policy_product')=='Motor Insurance')
        {
        

        $time = explode(" - ", $request->input('insurance_period'));


         $affectedRows = Policy::where('id', $request->input('policyid'))
            ->update(array(

                           'policy_insurer' =>  $request->input('policy_insurer'),
                           'policy_currency' =>  $request->input('policy_currency'),
                           'insurance_period_from' => $this->change_date_format($time[0]), 
                           'insurance_period_to' =>$this->change_date_format($time[1])));

            if($affectedRows > 0)
            {
                $affected = MotorDetails::where('id',$request->input('detailid'))
            ->update(array(
                           
                           'preferedcover'              =>  $request->input('preferedcover'),
                           'vehicle_currency'           =>  $request->input('vehicle_currency'),
                           'vehicle_value'              =>  $request->input('vehicle_value'),
                           'vehicle_buy_back_excess'    =>  $request->input('vehicle_buy_back_excess'),
                           'vehicle_tppdl_standard'     =>  $request->input('vehicle_tppdl_standard'),
                           'vehicle_tppdl_value'        =>  $request->input('vehicle_tppdl_value'),
                           'vehicle_body_type'          =>  $request->input('vehicle_body_type'),
                           'vehicle_model'              =>  $request->input('vehicle_model'),
                           'vehicle_make'               =>  $request->input('vehicle_make'),
                           'vehicle_use'                =>  $request->input('vehicle_use'),
                           'vehicle_make_year'          =>  $request->input('vehicle_make_year'),
                           'vehicle_seating_capacity'   =>  $request->input('vehicle_seating_capacity'),
                           'vehicle_cubic_capacity'     =>  $request->input('vehicle_cubic_capacity'),
                           'vehicle_registration_number' =>  $request->input('vehicle_registration_number'),
                           'vehicle_chassis_number'     =>  $request->input('vehicle_chassis_number'),
                           'vehicle_interest_status'    =>  $request->input('vehicle_interest_status'),
                           'vehicle_interest_name'      =>  $request->input('vehicle_interest_name'),

                           'vehicle_declined_status'    =>  $request->input('vehicle_declined_status'),
                           'vehicle_declined_reason'    =>  $request->input('vehicle_declined_reason'),
                           'vehicle_cancelled_status'   =>  $request->input('vehicle_cancelled_status'),
                           'vehicle_cancelled_reason'   =>  $request->input('vehicle_cancelled_reason'),

                           'vehicle_risk'               =>  $request->input('vehicle_risk'),
                           'vehicle_ncd'                =>  $request->input('vehicle_ncd'),
                           'vehicle_fleet_discount'     =>  $request->input('vehicle_fleet_discount')));

                                $bill                               = new Bill;
                                $bill->invoice_number               = $invoicenumberval;
                                $bill->account_number               = $request->input('customer_number');
                                $bill->account_name                 = $request->input('billed_to'); 
                                $bill->policy_number                = $request->input('policy_number');
                                $bill->policy_product               = $request->input('policy_product');
                                $bill->currency                     = $request->input('policy_currency');
                                $bill->amount                       = $request->input('gross_premium'); 
                                $bill->commission_rate              = $request->input('commission_rate'); 
                                $bill->note                         = $request->input('collection_mode'); 
                                $bill->reference_number             = $policyref; 
                                $bill->status                       = 'Unpaid';   
                                $bill->paid_amount                  = 0; 
                                $bill->created_by                   = Auth::user()->getNameOrUsername();
                                $bill->created_on                   = Carbon::now();
                                $bill->save();


                        if($affected > 0)
                        {
                              


                            return redirect()
                                        ->route('online-policies')
                                        ->with('success','Policy renew successfully!');

                        }

                        else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Motor Policy failed to renew!');
                        }
            
                }
               else
                        {
                                         return redirect()
                                        ->route('invoice')
                                        ->with('info','Policy renewed!');
                        }
        
        

      
        }

  //Fire Policy
   
 if($request->input('policy_product')=='Fire Insurance')
        {
   
             $time = explode(" - ", $request->input('insurance_period'));


         $affectedRows = Policy::where('id', $request->input('policyid'))
            ->update(array(

                           'policy_insurer' =>  $request->input('policy_insurer'),
                           'insurance_period_from' => $this->change_date_format($time[0]), 
                           'insurance_period_to' =>$this->change_date_format($time[1])));

            if($affectedRows > 0)
            {
                $affected = FireDetails::where('id',$request->input('detailid'))
            ->update(array(
                           
                           'fire_risk_covered'              =>  $request->input('fire_risk_covered'),
                           'fire_building_cost'             =>  $request->input('fire_building_cost'),
                           'fire_deductible'                =>  $request->input('fire_deductible'),
                           'fire_personal_property_coverage'=>  $request->input('fire_personal_property_coverage'),
                           'fire_temporary_rental_cost'     =>  $request->input('fire_temporary_rental_cost'),
                           'fire_building_address'          =>  $request->input('fire_building_address'),
                           'fire_property_type'             =>  $request->input('fire_property_type'),
                           'walled_with'                    =>  $request->input('walled_with'),
                           'roofed_with'                    =>  $request->input('roofed_with'),
                           'fire_mortgage_status'           =>  $request->input('fire_mortgage_status'),
                           'fire_mortgage_company'          =>  $request->input('fire_mortgage_company'),
                           'property_content'               =>  $request->input('property_content')));

                                $bill                               = new Bill;
                                $bill->invoice_number               = $invoicenumberval;
                                $bill->account_number               = $request->input('customer_number');
                                $bill->account_name                 = $request->input('billed_to'); 
                                $bill->policy_number                = $request->input('policy_number');
                                $bill->policy_product               = $request->input('policy_product');
                                $bill->currency                     = $request->input('policy_currency');
                                $bill->amount                       = $request->input('gross_premium'); 
                                $bill->commission_rate              = $request->input('commission_rate'); 
                                $bill->note                         = $request->input('collection_mode'); 
                                $bill->reference_number             = $policyref; 
                                $bill->status                       = 'Unpaid';   
                                $bill->paid_amount                  = 0; 
                                $bill->created_by                   = Auth::user()->getNameOrUsername();
                                $bill->created_on                   = Carbon::now();
                                $bill->save();

                          
                        if($affected > 0)
                        {
                            return redirect()
                                        ->route('online-policies')
                                        ->with('success','Policy updated successfully!');

                        }

                        else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }
            
                }
                else
                        {
                                         return redirect()
                                        ->route('invoice')
                                        ->with('info','Policy renewed!');
                        }   

      }
    
//Marine Insurance

if($request->input('policy_product')=='Marine Insurance')
        {
    


         $time = explode(" - ", $request->input('insurance_period'));
         $affectedRows = Policy::where('id', $request->input('policyid'))
            ->update(array(

                           'policy_insurer' =>  $request->input('policy_insurer'),
                           'insurance_period_from' => $this->change_date_format($time[0]), 
                           'insurance_period_to' =>$this->change_date_format($time[1])));

            if($affectedRows > 0)
            {
                $affected = FireDetails::where('id',$request->input('detailid'))
            ->update(array(
                           
                           'marine_risk_type'           =>  $request->input('marine_risk_type'),
                           'marine_sum_insured'         =>  $request->input('marine_sum_insured'),
                           'marine_bill_landing'        =>  $request->input('marine_bill_landing'),
                           'marine_interest'            =>  $request->input('marine_interest'),
                           'marine_vessel'              =>  $request->input('marine_vessel'),
                           'marine_insurance_condition' =>  $request->input('marine_insurance_condition'),
                           'marine_valuation'           =>  $request->input('marine_valuation'),
                           'marine_means_of_conveyance' =>  $request->input('marine_means_of_conveyance'),
                           'marine_voyage'              =>  $request->input('marine_voyage'),
                           'marine_condition'           =>  $request->input('marine_condition')));

                               $bill                               = new Bill;
                                $bill->invoice_number               = $invoicenumberval;
                                $bill->account_number               = $request->input('customer_number');
                                $bill->account_name                 = $request->input('billed_to'); 
                                $bill->policy_number                = $request->input('policy_number');
                                $bill->policy_product               = $request->input('policy_product');
                                $bill->currency                     = $request->input('policy_currency');
                                $bill->amount                       = $request->input('gross_premium'); 
                                $bill->commission_rate              = $request->input('commission_rate'); 
                                $bill->note                         = $request->input('collection_mode'); 
                                $bill->reference_number             = $policyref; 
                                $bill->status                       = 'Unpaid';   
                                $bill->paid_amount                  = 0; 
                                $bill->created_by                   = Auth::user()->getNameOrUsername();
                                $bill->created_on                   = Carbon::now();
                                $bill->save();

                          
                        if($affected > 0)
                        {
                            return redirect()
                                        ->route('online-policies')
                                        ->with('success','Policy updated successfully!');

                        }

                        else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }
            
                } 
                else
                        {
                                         return redirect()
                                        ->route('invoice')
                                        ->with('info','Policy renewed!');
                        }  

   
      }


      //Engineering Insurance

if($request->input('policy_product')=='Engineering Insurance')
{
        
       
         $time = explode(" - ", $request->input('insurance_period'));
         $affectedRows = Policy::where('id', $request->input('policyid'))
            ->update(array(

                           'policy_insurer' =>  $request->input('policy_insurer'),
                           'insurance_period_from' => $this->change_date_format($time[0]), 
                           'insurance_period_to' =>$this->change_date_format($time[1])));

            if($affectedRows > 0)
            {
                $affected = EngineeringDetails::where('id',$request->input('detailid'))
            ->update(array(
                           
                           'car_risk_type'           =>  $request->input('car_risk_type'),
                           'car_parties'             =>  $request->input('car_parties'),
                           'car_nature_of_business'  =>  $request->input('car_nature_of_business'),
                           'car_contract_description'=>  $request->input('car_contract_description'),
                           'car_contract_sum'        =>  $request->input('car_contract_sum'),
                           'car_deductible'          =>  $request->input('car_deductible'),
                           'car_endorsements'        =>  $request->input('car_endorsements')));

                                $bill                               = new Bill;
                                $bill->invoice_number               = $invoicenumberval;
                                $bill->account_number               = $request->input('customer_number');
                                $bill->account_name                 = $request->input('billed_to'); 
                                $bill->policy_number                = $request->input('policy_number');
                                $bill->policy_product               = $request->input('policy_product');
                                $bill->currency                     = $request->input('policy_currency');
                                $bill->amount                       = $request->input('gross_premium'); 
                                $bill->commission_rate              = $request->input('commission_rate'); 
                                $bill->note                         = $request->input('collection_mode'); 
                                $bill->reference_number             = $policyref; 
                                $bill->status                       = 'Unpaid';   
                                $bill->paid_amount                  = 0; 
                                $bill->created_by                   = Auth::user()->getNameOrUsername();
                                $bill->created_on                   = Carbon::now();
                                $bill->save();
                          
                        if($affected > 0)
                        {
                            return redirect()
                                        ->route('online-policies')
                                        ->with('success','Policy updated successfully!');

                        }

                        else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }
            
                } 
                else
                        {
                                         return redirect()
                                        ->route('invoice')
                                        ->with('info','Policy renewed!');
                        }  
       
}


if($request->input('policy_product')=='Liability Insurance')
{
        
        $time = explode(" - ", $request->input('insurance_period'));
        $affectedRows = Policy::where('id', $request->input('policyid'))
            ->update(array(

                           'policy_insurer' =>  $request->input('policy_insurer'),
                           'insurance_period_from' => $this->change_date_format($time[0]), 
                           'insurance_period_to' =>$this->change_date_format($time[1])));

            if($affectedRows > 0)
            {
                $affected = LiabilityDetails::where('id',$request->input('detailid'))
            ->update(array(
                           
                           'liability_risk_type'        =>  $request->input('liability_risk_type'),
                           'liability_schedule'         =>  $request->input('liability_schedule'),
                           'liability_schedule'         =>  $request->input('liability_schedule'),
                           'liability_beneficiary'      =>  $request->input('liability_beneficiary')));

                              $bill                               = new Bill;
                                $bill->invoice_number               = $invoicenumberval;
                                $bill->account_number               = $request->input('customer_number');
                                $bill->account_name                 = $request->input('billed_to'); 
                                $bill->policy_number                = $request->input('policy_number');
                                $bill->policy_product               = $request->input('policy_product');
                                $bill->currency                     = $request->input('policy_currency');
                                $bill->amount                       = $request->input('gross_premium'); 
                                $bill->commission_rate              = $request->input('commission_rate'); 
                                $bill->note                         = $request->input('collection_mode'); 
                                $bill->reference_number             = $policyref; 
                                $bill->status                       = 'Unpaid';   
                                $bill->paid_amount                  = 0; 
                                $bill->created_by                   = Auth::user()->getNameOrUsername();
                                $bill->created_on                   = Carbon::now();
                                $bill->save();

                          
                        if($affected > 0)
                        {
                            return redirect()
                                        ->route('online-policies')
                                        ->with('success','Policy updated successfully!');

                        }

                        else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }
            
                }
                else
                        {
                                         return redirect()
                                        ->route('invoice')
                                        ->with('info','Policy renewed!');
                        } 
        
     
}


if($request->input('policy_product')=='Health Insurance')
        {
    
        $time = explode(" - ", $request->input('insurance_period'));
        $affectedRows = Policy::where('id', $request->input('policyid'))
            ->update(array(

                           'policy_insurer'        =>   $request->input('policy_insurer'),
                           'insurance_period_from' =>   $this->change_date_format($time[0]), 
                           'insurance_period_to'   =>   $this->change_date_format($time[1])));

            if($affectedRows > 0)
            {
                $affected = HealthDetail::where('id',$request->input('detailid'))
            ->update(array(
                           
                           'health_type'            =>  $request->input('health_type'),
                           'health_plan_details'    =>  $request->input('health_plan_details'),
                           'health_plan_limits'     =>  $request->input('health_plan_limits')));

                                $bill                               = new Bill;
                                $bill->invoice_number               = $invoicenumberval;
                                $bill->account_number               = $request->input('customer_number');
                                $bill->account_name                 = $request->input('billed_to'); 
                                $bill->policy_number                = $request->input('policy_number');
                                $bill->policy_product               = $request->input('policy_product');
                                $bill->currency                     = $request->input('policy_currency');
                                $bill->amount                       = $request->input('gross_premium'); 
                                $bill->commission_rate              = $request->input('commission_rate'); 
                                $bill->note                         = $request->input('collection_mode'); 
                                $bill->reference_number             = $policyref; 
                                $bill->status                       = 'Unpaid';   
                                $bill->paid_amount                  = 0; 
                                $bill->created_by                   = Auth::user()->getNameOrUsername();
                                $bill->created_on                   = Carbon::now();
                                $bill->save();
                          
                        if($affected > 0)
                        {
                            return redirect()
                                        ->route('online-policies')
                                        ->with('success','Policy updated successfully!');

                        }

                        else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }
            
                }
                else
                        {
                                         return redirect()
                                        ->route('invoice')
                                        ->with('info','Policy renewed!');
                        }
     
      }



if($request->input('policy_product')=='Life Insurance')
    {
    
        $time = explode(" - ", $request->input('insurance_period'));
        $affectedRows = Policy::where('id', $request->input('policyid'))
            ->update(array(

                           'policy_insurer'         => $request->input('policy_insurer'),
                           'insurance_period_from'  => $this->change_date_format($time[0]), 
                           'insurance_period_to'    => $this->change_date_format($time[1])));

            if($affectedRows > 0)
            {
                $affected = LifeDetail::where('id',$request->input('detailid'))
            ->update(array(
                           
                           'life_type'              =>  $request->input('life_type'),
                           'life_cover_amount'      =>  $request->input('life_cover_amount'),
                           'life_monthly_premium'   =>  $request->input('life_monthly_premium'),
                           'life_plan_details'      =>  $request->input('life_plan_details'),
                           'life_plan_limits'       =>  $request->input('life_plan_limits')));

                               $bill                               = new Bill;
                                $bill->invoice_number               = $invoicenumberval;
                                $bill->account_number               = $request->input('customer_number');
                                $bill->account_name                 = $request->input('billed_to'); 
                                $bill->policy_number                = $request->input('policy_number');
                                $bill->policy_product               = $request->input('policy_product');
                                $bill->currency                     = $request->input('policy_currency');
                                $bill->amount                       = $request->input('gross_premium'); 
                                $bill->commission_rate              = $request->input('commission_rate'); 
                                $bill->note                         = $request->input('collection_mode'); 
                                $bill->reference_number             = $policyref; 
                                $bill->status                       = 'Unpaid';   
                                $bill->paid_amount                  = 0; 
                                $bill->created_by                   = Auth::user()->getNameOrUsername();
                                $bill->created_on                   = Carbon::now();
                                $bill->save();

                          
                        if($affected > 0)
                        {
                            return redirect()
                                        ->route('online-policies')
                                        ->with('success','Policy updated successfully!');

                        }

                        else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }
            
            }
            else
                        {
                                         return redirect()
                                        ->route('invoice')
                                        ->with('info','Policy renewed!');
                        }
   

    }



//Bond Insurance

if($request->input('policy_product')=='Bond Insurance')
        {

        $time = explode(" - ", $request->input('insurance_period'));
        $affectedRows = Policy::where('id', $request->input('policyid'))
            ->update(array(

                           'policy_insurer'         => $request->input('policy_insurer'),
                           'insurance_period_from'  => $this->change_date_format($time[0]), 
                           'insurance_period_to'    => $this->change_date_format($time[1])));

            if($affectedRows > 0)
            {
                $affected = BondDetails::where('id',$request->input('detailid'))
            ->update(array(
                           
                           'bond_risk_type'                 =>  $request->input('bond_risk_type'),
                           'bond_interest'                  =>  $request->input('bond_interest'),
                           'bond_interest_address'          =>  $request->input('bond_interest_address'),
                           'contract_sum'                   =>  $request->input('contract_sum'),
                           'bond_sum_insured'               =>  $request->input('bond_sum_insured'),
                           'bond_contract_description'      =>  $request->input('bond_contract_description')));

                                $bill                               = new Bill;
                                $bill->invoice_number               = $invoicenumberval;
                                $bill->account_number               = $request->input('customer_number');
                                $bill->account_name                 = $request->input('billed_to'); 
                                $bill->policy_number                = $request->input('policy_number');
                                $bill->policy_product               = $request->input('policy_product');
                                $bill->currency                     = $request->input('policy_currency');
                                $bill->amount                       = $request->input('gross_premium'); 
                                $bill->commission_rate              = $request->input('commission_rate'); 
                                $bill->note                         = $request->input('collection_mode'); 
                                $bill->reference_number             = $policyref; 
                                $bill->status                       = 'Unpaid';   
                                $bill->paid_amount                  = 0; 
                                $bill->created_by                   = Auth::user()->getNameOrUsername();
                                $bill->created_on                   = Carbon::now();
                                $bill->save();
                          
                        if($affected > 0)
                        {
                            return redirect()
                                        ->route('online-policies')
                                        ->with('success','Policy updated successfully!');

                        }

                        else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }


            
            }

          else
                        {
                                         return redirect()
                                        ->route('invoice')
                                        ->with('info','Policy renewed!');
                        }

       
      }
    

//General Accident
if($request->input('policy_product')=='General Accident Insurance')
    {
        
            $time = explode(" - ", $request->input('insurance_period'));
            $affectedRows = Policy::where('id', $request->input('policyid'))
            ->update(array(

                           'policy_insurer'         => $request->input('policy_insurer'),
                           'insurance_period_from'  => $this->change_date_format($time[0]), 
                           'insurance_period_to'    => $this->change_date_format($time[1])));

            if($affectedRows > 0)
            {
                $affected = AccidentDetails::where('id',$request->input('detailid'))
            ->update(array(
                           
                           'accident_risk_type'             =>  $request->input('accident_risk_type'),
                           'general_accident_sum_insured'   =>  $request->input('general_accident_sum_insured'),
                           'general_accident_deductible'    =>  $request->input('general_accident_deductible'),
                           'accident_description'           =>  $request->input('accident_description'),
                           'accident_beneficiaries'         =>  $request->input('accident_beneficiaries'),
                           'accident_clause_limit'          =>  $request->input('accident_clause_limit')));

                               $bill                               = new Bill;
                                $bill->invoice_number               = $invoicenumberval;
                                $bill->account_number               = $request->input('customer_number');
                                $bill->account_name                 = $request->input('billed_to'); 
                                $bill->policy_number                = $request->input('policy_number');
                                $bill->policy_product               = $request->input('policy_product');
                                $bill->currency                     = $request->input('policy_currency');
                                $bill->amount                       = $request->input('gross_premium'); 
                                $bill->commission_rate              = $request->input('commission_rate'); 
                                $bill->note                         = $request->input('collection_mode'); 
                                $bill->reference_number             = $policyref; 
                                $bill->status                       = 'Unpaid';   
                                $bill->paid_amount                  = 0; 
                                $bill->created_by                   = Auth::user()->getNameOrUsername();
                                $bill->created_on                   = Carbon::now();
                                $bill->save();

                          
                        if($affected > 0)
                        {
                            return redirect()
                                        ->route('online-policies')
                                        ->with('success','Policy updated successfully!');

                        }

                        else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }
            
            }
            else
                        {
                                         return redirect()
                                        ->route('invoice')
                                        ->with('info','Policy renewed!');
                        }
    }


// Travel Poloicy

    if($request->input('policy_product')=='Travel Insurance')
    {
    
            $time = explode(" - ", $request->input('insurance_period'));
            $affectedRows = Policy::where('id', $request->input('policyid'))
            ->update(array(

                           'policy_insurer'         => $request->input('policy_insurer'),
                           'insurance_period_from'  => $this->change_date_format($time[0]), 
                           'insurance_period_to'    => $this->change_date_format($time[1])));
            
            if($affectedRows > 0)
            {
                $affected = TravelDetails::where('id',$request->input('detailid'))
            ->update(array(
                           
                           'destination_country'             =>  implode($request->input('destination_country'), ', '),
                           'departure_date'                  =>  $request->input('departure_date'),
                           'arrival_date'                    =>  $request->input('arrival_date'),
                           'passport_number'                 =>  $request->input('passport_number'),
                           'issuing_country'                 =>  $request->input('issuing_country'),
                           'citizenship'                     =>  $request->input('citizenship'),
                           'beneficiary_name'                =>  $request->input('beneficiary_name'),
                           'beneficiary_relationship'        =>  $request->input('beneficiary_relationship'),
                           'beneficiary_contact'             =>  $request->input('beneficiary_contact'),
                           'travel_reason'                   =>  $request->input('travel_reason')));

                                $bill                               = new Bill;
                                $bill->invoice_number               = $invoicenumberval;
                                $bill->account_number               = $request->input('customer_number');
                                $bill->account_name                 = $request->input('billed_to'); 
                                $bill->policy_number                = $request->input('policy_number');
                                $bill->policy_product               = $request->input('policy_product');
                                $bill->currency                     = $request->input('policy_currency');
                                $bill->amount                       = $request->input('gross_premium'); 
                                $bill->commission_rate              = $request->input('commission_rate'); 
                                $bill->note                         = $request->input('collection_mode'); 
                                $bill->reference_number             = $policyref; 
                                $bill->status                       = 'Unpaid';   
                                $bill->paid_amount                  = 0; 
                                $bill->created_by                   = Auth::user()->getNameOrUsername();
                                $bill->created_on                   = Carbon::now();
                                $bill->save();

                          dd($affected);
                        if($affected > 0)
                        {
                            return redirect()
                                        ->route('online-policies')
                                        ->with('success','Policy updated successfully!');

                        }

                        else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }
            
            }
            else
                        {
                                         return redirect()
                                        ->route('invoice')
                                        ->with('info','Policy renewed!');
                        }
        
      }


      if($request->input('policy_product')=='Personal Accident Insurance')

        {
        
        $time = explode(" - ", $request->input('insurance_period'));
            $affectedRows = Policy::where('id', $request->input('policyid'))
            ->update(array(

                           'policy_insurer'         => $request->input('policy_insurer'),
                           'insurance_period_from'  => $this->change_date_format($time[0]), 
                           'insurance_period_to'    => $this->change_date_format($time[1])));

            if($affectedRows > 0)
            {
                $affected = Accident::where('id',$request->input('detailid'))
            ->update(array(
                           
                           'pa_sum_insured'             =>  $request->input('pa_sum_insured'),
                           'pa_height'                  =>  $request->input('pa_height'),
                           'pa_weight'                  =>  $request->input('pa_weight'),
                           'marital_status'             =>  $request->input('marital_status'),
                           'nature_of_work'             =>  $request->input('nature_of_work'),
                           'pa_accident_received'       =>  $request->input('pa_accident_received'),
                           'pa_nature_of_accident'      =>  $request->input('pa_nature_of_accident'),
                           'accident_duration'          =>  $request->input('accident_duration'),
                           'accident_period'            =>  $request->input('accident_period'),
                           'pa_activities'              =>  $request->input('pa_activities'),
                           'pa_special_term_status'     =>  $request->input('pa_special_term_status'),
                           'pa_cancelled_insurance_status' =>  $request->input('pa_cancelled_insurance_status'),
                           'pa_increased_premium_status'   =>  $request->input('pa_increased_premium_status'),
                           'pa_benefit_details'            =>  $request->input('pa_benefit_details')));


                                $bill                               = new Bill;
                                $bill->invoice_number               = $invoicenumberval;
                                $bill->account_number               = $request->input('customer_number');
                                $bill->account_name                 = $request->input('billed_to'); 
                                $bill->policy_number                = $request->input('policy_number');
                                $bill->policy_product               = $request->input('policy_product');
                                $bill->currency                     = $request->input('policy_currency');
                                $bill->amount                       = $request->input('gross_premium'); 
                                $bill->commission_rate              = $request->input('commission_rate'); 
                                $bill->note                         = $request->input('collection_mode'); 
                                $bill->reference_number             = $policyref; 
                                $bill->status                       = 'Unpaid';   
                                $bill->paid_amount                  = 0; 
                                $bill->created_by                   = Auth::user()->getNameOrUsername();
                                $bill->created_on                   = Carbon::now();
                                $bill->save();

                          
                        if($affected > 0)
                        {
                            return redirect()
                                        ->route('online-policies')
                                        ->with('success','Policy updated successfully!');

                        }

                        else
                        {
                                         return redirect()
                                        ->route('online-policies')
                                        ->with('error','Policy failed to update!');
                        }
            
            }

            else
                        {
                                         return redirect()
                                        ->route('invoice')
                                        ->with('info','Policy renewed!');
                        }
       
       

        }

}
}

