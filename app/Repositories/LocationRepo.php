<?php

namespace App\Repositories;

use App\Models\City;
use App\Models\District;
use App\Models\Nationality;
use App\Models\Province;
use App\Models\State;
use App\Models\Lga;
use App\Models\SubDistrict;

class LocationRepo
{
    public function getStates()
    {
        return State::all();
    }

    public function getAllStates()
    {
        return State::orderBy('name', 'asc')->get();
    }

    public function getAllProvinces()
    {
        return Province::orderBy('prov_name', 'asc')->get();
    }

    public function getCities($prov_id)
    {
        return City::where('prov_id', $prov_id)->orderBy('city_name', 'asc')->get();
    }

    public function getDistricts($city_id)
    {   
        return District::where('city_id', $city_id)->orderBy('dis_name', 'asc')->get();
    }

    public function getSubDistricts($dis_id)
    {
        return SubDistrict::where('dis_id', $dis_id)->orderBy('subdis_name', 'asc')->get();
    }

    public function getAllNationals()
    {
        return Nationality::orderBy('name', 'asc')->get();
    }

    public function getLGAs($state_id)
    {
        return Lga::where('state_id', $state_id)->orderBy('name', 'asc')->get();
    }

}