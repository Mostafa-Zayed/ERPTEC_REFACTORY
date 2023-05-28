@extends('layouts.app')
@section('title', 'shipment')
@section('content')
@php
    $pickupCity = '';
@endphp
<!-- Main content -->
<section class="content">
    <div class="default-box">
        <div class="default-box-body">

            {!! Form::open(['url' => action('Admin\ShipmentController@updateshipmentsetting',[$siting->id]), 'method' => 'post', 'id' =>  $quick_add ? 'quick_add_trafic_form' : 'campaigns_add_form' ]) !!}
        
            <div class="modal-body">
                
              @if($sshipment->name =="Bosta/Api")
              <div class="form-group">
                   {!! Form::label('bosat_key', __( 'sale.bosta key' ) . ':*') !!}
                  {!! Form::text('bosta_key', $siting->bosta_key, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.bosta key' ) ]); !!}
              </div> 
             
             <div class="form-group">
                   {!! Form::label('bosatlink', __( 'sale.bosta link' ) . ':*') !!}
                  {!! Form::text('bostalink', $siting->bostalink, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.bosta link' ) ]); !!}
              </div> 
              <div class="form-group">
                   {!! Form::label('bosta_description', __( 'sale.bosta_description' ) . ':*') !!}
                  {!! Form::text('bosta_description', $siting->bosta_description, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.bosta_description' ) ]); !!}
              </div>
               <div class="form-group">
                  <label>{{__('sale.allow open bosta shipment')}}</label>
                  <input name="bosta_allow_open" class="form-check-input" type="checkbox" {{($siting->bosta_allow_open === 1) ? "checked" : ""}} >
              </div>
              @endif
              
              @if($sshipment->name == "Fastlo/Api")
              <div class="form-group">
                {!! Form::label('fastloapi', __( 'sale.fastlo key' ) . ':*') !!}
                  {!! Form::text('fastloapi', $siting->fastloapi, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.fastlo key' ) ]); !!}
              </div>
              
              @endif
              
               
            @if($sshipment->name == "Picks/Api")
              <div class="form-group">
                {!! Form::label('pickskey', __( 'sale.picks key' ) . ':*') !!}
                  {!! Form::text('pickskey', $siting->pickskey, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.picks key' ) ]); !!}
              </div>
              
              @endif
              
             @if($sshipment->name == "Fedex/Api")
               <div class="form-group">
                 {!! Form::label('fedex_account', __( 'sale.fedex account' ) . ':*') !!}
                 {!! Form::text('fedex_account', $siting->fedex_account, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.fedex account' ) ]); !!}
              </div>   
              <div class="form-group">
                {!! Form::label('fedex_password', __( 'sale.fedex password' ) . ':*') !!}
                  {!! Form::text('fedex_password', $siting->fedex_password, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.fedex password' ) ]); !!}
              </div>  
              
              <div class="form-group">
                {!! Form::label('fedex_privatehash', __( 'sale.fedex privatehash' ) . ':*') !!}
                  {!! Form::text('fedex_privatehash', $siting->fedex_privatehash, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.fedex privatehash' ) ]); !!}
              </div>
              @endif
               
             
              @if($sshipment->name == "Aramex/Api")
              
            <div class="form-group">
                {!! Form::label('aramex_user', __( 'sale.aramex user' ) . ':*') !!}
                  {!! Form::text('aramex_user', $siting->aramex_user, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.aramex user') ]); !!}
              </div>  
              <div class="form-group">
                {!! Form::label('aramex_password', __( 'sale.aramex password' ) . ':*') !!}
                 {!! Form::text('aramex_password', $siting->aramex_password, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.aramex password') ]); !!}
              </div>   
              <div class="form-group">
                {!! Form::label('aramex_number', __( 'sale.aramex number' ) . ':*') !!}
                  {!! Form::text('aramex_number', $siting->aramex_number, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.aramex account') ]); !!}
              </div>
             
            <div class="form-group">
                {!! Form::label('aramex_pin', __( 'sale.aramex pin' ) . ':*') !!}
                 {!! Form::text('aramex_pin', $siting->aramex_pin, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.aramex pin') ]); !!}
              </div>   
              
              <div class="form-group">
                {!! Form::label('aramex_entity', __( 'sale.aramex entity' ) . ':*') !!}
                  {!! Form::text('aramex_entity', $siting->aramex_entity, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.aramex entity') ]); !!}
              </div>
              
              <div class="form-group">
                  
                  {!! Form::label('aramex_link', __( 'sale.aramex link' ) . ':*') !!}
                 
                  {!! Form::text('aramex_link', $siting->aramex_link, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.aramex link') ]); !!}
              </div>
              
             <div class="form-group">
                    {!! Form::label('country', 'County :*') !!}
                    <select id="aramex_country" name="aramex_country" class="form-control select2">
                        <option value="">Select</option>
                        <option value="EG">Egypt</option>
                        <option value="SA">Saudi Arabia</option>
                    </select>
                </div>
               
              
                <div class="form-group" id="egyptAreas" style="display:none;">
        			{!! Form::label('ships_zone', __('sale.aramexshipfrom') . ':') !!}
        			
        			<select class="shipment_id form-control select2" style="width:100%">
        				
        						    <option value="">Select</option>
        						    <option value="Ain Shams">Ain shams</option> 
        						    <option value="El Salam City">Al salam</option>
        						    <option value="Al Marg">El marg</option>
        						    <option value="Heliopolis">Heliopolis</option>
        						    <option value="Atfeah">Atfeah</option> 
        						    <option value="Nasr City">Nasr city</option>
        						    <option value="Zamalek">Zamalek</option>
        						    <option value="El Zeitoun">El Zeitoun</option>
        						    <option value="Mokattam">Mokattam</option>
        						    <option value="Torah">Torah</option>
        						    <option value="Moustorod">Moustorod</option>
        						    <option value="Meet Ghamr">Meet Ghamr</option>
        						    <option value="Badr City">Badr City</option>
        						    <option value="Boulak">Boulak</option>
        						    <option value="Benha">Banha</option>
        		                    <option value="Qasr elneil">Qasr elneil</option> 
        						    <option value="Marsa Matrouh">Marsa Matrouh</option>
        						    <option value="Marinah">Marinah</option>
        						    <option value="Attaba">Attaba</option>
        						    <option value="Kasr El Einy">Kasr El Einy</option>
        						    <option value="Hadayek El Qobah">Hadayek El Qobah</option>
        						    <option value="15 Of May City">15th may</option>
        						    <option value="Helwan">Helwan</option>
        						    <option value="EL GOUNA">EL GOUNA</option>
        						    <option value="Maadi">Maadi</option>
        						    <option value="Madinaty">Madinaty</option> 
        						    <option value="Manial El Rodah">Manial</option>
        						    <option value="Taba City">Taba City</option>
        						    <option value="New Cairo">New cairo</option>
        						    <option value="Al Shorouk">El shourok</option>
        						   <option value="Shoubra">Shoubra</option> 
        						    <option value="Mansheyt Naser">Mansheyt Naser</option>
        						    <option value="Ramsis">Ramsis</option>
        						    <option value="RAS GHAREB">RAS GHAREB</option>
        						    <option value="El Hawamdiah">El Hawamdiah</option> 
        						    <option value="Badrashin">Badrashin</option>
        						    <option value="Tebin">Tebin</option>
        						    <option value="El Ayat">El Ayat</option>
        						    <option value="El Saf">El Saf</option>
        						   <option value="Ghamrah">Ghamrah</option> 
        						    <option value="Abu Zaabal">Abu Zaabal</option>
        						    <option value="Abasya">Abasya</option>
        						    <option value="Ras Seidr">Ras Seidr</option>
        						    <option value="Shebin El Koum">Shebin El Koum</option>
        						   <option value="Al Matarya">Al Matarya</option> 
        						    <option value="Shubra">Shubra</option>
        						    <option value="Shubra El Kheima">Shoubra el khaima</option>
        						   <option value="Al Obour City">Al obor</option> 
        						    <option value="10Th Of Ramadan City">10 of ramadan</option>
        						    <option value="Katamiah">Katamiah</option>
        						    <option value="Garden City">Garden City</option>
        						   <option value="Al Nobariah">Al Nobariah</option> 
        						    <option value="Sadat City">Sadat City</option>
        						    <option value="Giza">Giza</option>
        						    <option value="Al Monib">Munib</option>
        						    <option value="Safaga">Safaga</option>
        						   <option value="EL rehab">EL rehab</option> 
        						    <option value="Saqara">Saqara</option>
        						    <option value="Nuwibaa">Nuwibaa</option>
        						    <option value="Abo Rawash">Abou rawash</option>
        						   <option value="Agouza">Agouza</option> 
        						    <option value="Dokki">Dokki</option>
        						    <option value="Marsa Alam">Marsa Alam</option>
        						    <option value="New Capital City">New Capital City</option>
        						    <option value="Al Haram">Haram</option>
        						   <option value="Imbaba">Imbaba</option> 
        						    <option value="Mohandiseen">Mohandseen</option>
        						    <option value="October City">6th of Oct</option>
        						    <option value="Sheikh Zayed">Sheikh Zayed</option>
        						    <option value="Omranya">Omranyea</option>
        						   <option value="Al Waraq">Warraq</option> 
        						    <option value="Alexandria">Alexandria</option>
        						    <option value="Assiut">Asuit</option>
        						    <option value="Aswan">Aswan</option>
        						    <option value="Damanhour">Damanhour</option>
        						   <option value="Bani Swif">Bani suef</option> 
        						    <option value="Mansoura">Mansoura</option>
        						    <option value="Dumiatta">Damita</option>
        						    <option value="Fayoum">Fayoum</option>
        						    <option value="Al Mahala">Gharbya</option>
        						   <option value="Ismailia">Ismalya</option> 
        						    <option value="Kafr Al Sheikh">Kafr elsheigh</option>
        						    <option value="Luxour">Luxour</option>
        						   <option value="Marsa Matrouh">Marsa Matrouh</option>
        						    <option value="Menia City">Minya</option>
        						    <option value="Al Menofiah">Al Menofiah</option>
        						    <option value="El Wadi El Gadid">El Wadi El Gadid</option>
        						   <option value="Wadi El Natroun">Wadi El Natroun</option> 
        						    <option value="Port Said">Port said</option>
        						    <option value="Qaliubia">Qalyoubya</option>
        						    <option value="Qena">Qena</option>
        						    <option value="Sharm El Sheikh">Sharm El Sheikh</option>
        						   <option value="Zakazik">Zakazik</option> 
        						    <option value="sohag City">Sohag</option>
        						    <option value="AL Qanater">AL Qanater</option>
        						   <option value="Suez">Suez</option>
        						    <option value="Siwa">Siwa</option>
        						</select>
        						
        		</div>
        					
        		<div class="form-group" id="saudiAreas" style="display:none;">
        		    
        		    {!! Form::label('ships_zone', __('sale.aramexshipfrom') . ':') !!}
        		    
        		    <select class="shipment_id form-control select2" style="width:100%">
        			    <option value="">Select</option>
        			    <option value="Aba Alworood">Aba Alworood</option>
                        <option value="Abha">Abha</option>
                        <option value="Abha Manhal">Abha Manhal</option>
                        <option value="Abqaiq">Abqaiq</option>
                        <option value="Abu Ajram">Abu Ajram</option>
                        <option value="Abu Areish">Abu Areish</option>
                        <option value="Ad Dahinah">Ad Dahinah</option>
                        <option value="Ad Dubaiyah">Ad Dubaiyah</option>
                        <option value="Addayer">Addayer</option>
                        <option value="Adham">Adham</option>
                        <option value="Afif">Afif</option>
                        <option value="Aflaj">Aflaj</option>
                        <option value="Ahad Masarha">Ahad Masarha</option>
                        <option value="Ahad Rufaidah">Ahad Rufaidah</option>
                        <option value="Ain Dar">Ain Dar</option>
                        <option value="Al Adari">Al Adari</option>
                        <option value="Al Ais">Al Ais</option>
                        <option value="Al Ajfar">Al Ajfar</option>
                        <option value="Al Ammarah">Al Ammarah</option>
                        <option value="Al Ardah">Al Ardah</option>
                        <option value="Al Arja">Al Arja</option>
                        <option value="Al Asyah">Al Asyah</option>
                        <option value="Al Bada">Al Bada</option>
                        <option value="Al Bashayer">Al Bashayer</option>
                        <option value="Al Batra">Al Batra</option>
                        <option value="Al Bijadyah">Al Bijadyah</option>
                        <option value="Al Dalemya">Al Dalemya</option>
                        <option value="Al Fuwaileq / Ar Rishawiyah">Al Fuwaileq / Ar Rishawiyah</option>
                        <option value="Al Haith">Al Haith</option>
                        <option value="Al Hassa">Al Hassa</option>
                        <option value="Al Hayathem">Al Hayathem</option>
                        <option value="Al Hufayyirah">Al Hufayyirah</option>
                        <option value="Al Hulayfah As Sufla">Al Hulayfah As Sufla</option>
                        <option value="Al Idabi">Al Idabi</option>
                        <option value="Al Khishaybi">Al Khishaybi</option>
                        <option value="Al Khitah">Al Khitah</option>
                        <option value="Al Laqayit">Al Laqayit</option>
                        <option value="Al Mada">Al Mada</option>
                        <option value="Al Mahd">Al Mahd</option>
                        <option value="Al Midrij">Al Midrij</option>
                        <option value="Al Moya">Al Moya</option>
                        <option value="Al Qarin">Al Qarin</option>
                        <option value="Al Uwayqilah">Al Uwayqilah</option>
                        <option value="Al Wasayta">Al Wasayta</option>
                        <option value="Alghat">Alghat</option>
                        <option value="Alhada">Alhada</option>
                        <option value="Al-Jsh">Al-Jsh</option>
                        <option value="Alnabhanya">Alnabhanya</option>
                        <option value="AlRass">AlRass</option>
                        <option value="Amaq">Amaq</option>
                        <option value="An Nabk Abu Qasr">An Nabk Abu Qasr</option>
                        <option value="An Nafiah">An Nafiah</option>
                        <option value="An Nuqrah">An Nuqrah</option>
                        <option value="Anak">Anak</option>
                        <option value="Aqiq">Aqiq</option>
                        <option value="Ar Radifah">Ar Radifah</option>
                        <option value="Ar Rafi'ah">Ar Rafi'ah</option>
                        <option value="Arar">Arar</option>
                        <option value="Artawiah">Artawiah</option>
                        <option value="As Sulaimaniyah">As Sulaimaniyah</option>
                        <option value="As Sulubiayh">As Sulubiayh</option>
                        <option value="Asfan">Asfan</option>
                        <option value="Ash Shaara">Ash Shaara</option>
            <option value="Ash Shamli">Ash Shamli</option>
            <option value="Ash Shananah">Ash Shananah</option>
            <option value="Ash Shimasiyah">Ash Shimasiyah</option>
            <option value="Ash Shuqaiq">Ash Shuqaiq</option>
            <option value="At Tuwayr">At Tuwayr</option>
            <option value="Atawleh">Atawleh</option>
            <option value="Ath Thybiyah">Ath Thybiyah</option>
            <option value="Awamiah">Awamiah</option>
            <option value="Ayn Fuhayd">Ayn Fuhayd</option>
            <option value="Badaya">Badaya</option>
            <option value="Bader">Bader</option>
            <option value="Badr Al Janoub">Badr Al Janoub</option>
            <option value="Baha">Baha</option>
            <option value="Bahara">Bahara</option>
            <option value="Bahrat Al Moujoud">Bahrat Al Moujoud</option>
            <option value="Balahmar">Balahmar</option>
            <option value="Balasmar">Balasmar</option>
            <option value="Balqarn">Balqarn</option>
            <option value="Baqa Ash Sharqiyah">Baqa Ash Sharqiyah</option>
            <option value="Baqaa">Baqaa</option>
            <option value="Baqiq">Baqiq</option>
            <option value="Bareq">Bareq</option>
            <option value="Batha">Batha</option>
            <option value="BilJurashi">BilJurashi</option>
            <option value="Birk">Birk</option>
            <option value="Bish">Bish</option>
            <option value="Bisha">Bisha</option>
            <option value="Bukeiriah">Bukeiriah</option>
            <option value="Buraidah">Buraidah</option>
            <option value="Daelim">Daelim</option>
            <option value="Damad">Damad</option>
            <option value="Dammam">Dammam</option>
            <option value="Darb">Darb</option>
            <option value="Dariyah">Dariyah</option>
            <option value="Dawadmi">Dawadmi</option>
            <option value="Deraab">Deraab</option>
            <option value="Dere'iyeh">Dere'iyeh</option>
            <option value="Dhahban">Dhahban</option>
            <option value="Dhahran">Dhahran</option>
            <option value="Dhahran Al Janoob">Dhahran Al Janoob</option>
            <option value="Dhurma">Dhurma</option>
            <option value="Domat Al Jandal">Domat Al Jandal</option>
            <option value="Duba">Duba</option>
            <option value="Duhknah">Duhknah</option>
            <option value="Dulay Rashid">Dulay Rashid</option>
            <option value="Farasan">Farasan</option>
            <option value="Ghazalah">Ghazalah</option>
            <option value="Ghtai">Ghtai</option>
            <option value="Gilwa">Gilwa</option>
            <option value="Gizan">Gizan</option>
            <option value="Hadeethah">Hadeethah</option>
            <option value="Hafer Al Batin">Hafer Al Batin</option>
            <option value="Hail">Hail</option>
            <option value="Hajrah">Hajrah</option>
            <option value="Halat Ammar">Halat Ammar</option>
            <option value="Hali">Hali</option>
            <option value="Haqil">Haqil</option>
            <option value="Harad">Harad</option>
            <option value="Harajah">Harajah</option>
            <option value="Hareeq">Hareeq</option>
            <option value="Hawea/Taif">Hawea/Taif</option>
            <option value="Haweyah/Dha">Haweyah/Dha</option>
            <option value="Hawtat Bani Tamim">Hawtat Bani Tamim</option>
            <option value="Hazm Al Jalamid">Hazm Al Jalamid</option>
            <option value="Hedeb">Hedeb</option>
            <option value="Hinakeya">Hinakeya</option>
            <option value="Hofuf">Hofuf</option>
            <option value="Horaimal">Horaimal</option>
            <option value="Hotat Sudair">Hotat Sudair</option>
            <option value="Hubuna">Hubuna</option>
            <option value="Huraymala">Huraymala</option>
            <option value="Ja'araneh">Ja'araneh</option>
            <option value="Jafar">Jafar</option>
            <option value="Jalajel">Jalajel</option>
            <option value="Jeddah">Jeddah</option>
            <option value="Jouf">Jouf</option>
            <option value="Jubail">Jubail</option>
            <option value="Jumum">Jumum</option>
            <option value="Kahlah">Kahlah</option>
            <option value="Kara">Kara</option>
            <option value="Kara'a">Kara'a</option>
            <option value="Karboos">Karboos</option>
            <option value="Khafji">Khafji</option>
            <option value="Khaibar">Khaibar</option>
            <option value="Khairan">Khairan</option>
            <option value="Khamaseen">Khamaseen</option>
            <option value="Khamis Mushait">Khamis Mushait</option>
            <option value="Kharj">Kharj</option>
            <option value="Khasawyah">Khasawyah</option>
            <option value="Khobar">Khobar</option>
            <option value="Khodaria">Khodaria</option>
            <option value="Khulais">Khulais</option>
            <option value="Khurma">Khurma</option>
            <option value="King Khalid Military City">King Khalid Military City</option>
            <option value="Kubadah">Kubadah</option>
            <option value="Laith">Laith</option>
            <option value="Layla">Layla</option>
            <option value="Madinah">Madinah</option>
            <option value="Mahad Al Dahab">Mahad Al Dahab</option>
            <option value="Majarda">Majarda</option>
            <option value="Majma">Majma</option>
            <option value="Makkah">Makkah</option>
            <option value="Mandak">Mandak</option>
            <option value="Mastura">Mastura</option>
            <option value="Mawqaq">Mawqaq</option>
            <option value="Midinhab">Midinhab</option>
            <option value="Mikhwa">Mikhwa</option>
            <option value="Mohayel Aseer">Mohayel Aseer</option>
            <option value="Moqaq">Moqaq</option>
            <option value="Mrat">Mrat</option>
            <option value="Mubaraz">Mubaraz</option>
            <option value="Mubayid">Mubayid</option>
            <option value="Mulaija">Mulaija</option>
            <option value="Mulayh">Mulayh</option>
            <option value="Munifat Al Qaid">Munifat Al Qaid</option>
            <option value="Muthaleif">Muthaleif</option>
            <option value="Muzahmiah">Muzahmiah</option>
            <option value="Muzneb">Muzneb</option>
            <option value="Nabiya">Nabiya</option>
            <option value="Najran">Najran</option>
            <option value="Namas">Namas</option>
            <option value="Nimra">Nimra</option>
            <option value="Nisab">Nisab</option>
            <option value="Noweirieh">Noweirieh</option>
            <option value="Nwariah">Nwariah</option>
            <option value="Ojam">Ojam</option>
            <option value="Onaiza">Onaiza</option>
            <option value="Othmanyah">Othmanyah</option>
            <option value="Oula">Oula</option>
            <option value="Oyaynah">Oyaynah</option>
            <option value="Oyoon Al Jawa">Oyoon Al Jawa</option>
            <option value="Qahmah">Qahmah</option>
            <option value="Qarah">Qarah</option>
            <option value="Qariya Al Olaya">Qariya Al Olaya</option>
            <option value="Qasab">Qasab</option>
            <option value="Qassim">Qassim</option>
            <option value="Qatif">Qatif</option>
            <option value="Qaysoomah">Qaysoomah</option>
            <option value="Qbah">Qbah</option>
            <option value="Qouz">Qouz</option>
            <option value="Qufar">Qufar</option>
            <option value="Qunfudah">Qunfudah</option>
            <option value="Qurayat">Qurayat</option>
            <option value="Qusayba">Qusayba</option>
            <option value="Quwei'ieh">Quwei'ieh</option>
            <option value="Rabigh">Rabigh</option>
            <option value="Rafha">Rafha</option>
            <option value="Rahima">Rahima</option>
            <option value="Rania">Rania</option>
            <option value="Ras Al Kheir">Ras Al Kheir</option>
            <option value="Ras Baridi">Ras Baridi</option>
            <option value="Ras Tanura">Ras Tanura</option>
            <option value="Rawdat Habbas">Rawdat Habbas</option>
            <option value="Rejal Alma'a">Rejal Alma'a</option>
            <option value="Remah">Remah</option>
            <option value="Riyadh">Riyadh</option>
            <option value="Riyadh Al Khabra">Riyadh Al Khabra</option>
            <option value="Rowdat Sodair">Rowdat Sodair</option>
            <option value="Rvaya Aljamsh">Rvaya Aljamsh</option>
            <option value="Rwaydah">Rwaydah</option>
            <option value="Sabt El Alaya">Sabt El Alaya</option>
            <option value="Sabya">Sabya</option>
            <option value="Sadal Malik">Sadal Malik</option>
            <option value="Sadyan">Sadyan</option>
            <option value="Safanyah">Safanyah</option>
            <option value="Safwa">Safwa</option>
            <option value="Sahna">Sahna</option>
            <option value="Sajir">Sajir</option>
            <option value="Sakaka">Sakaka</option>
            <option value="Salbookh">Salbookh</option>
            <option value="Salwa">Salwa</option>
            <option value="Samakh">Samakh</option>
            <option value="Samtah">Samtah</option>
            <option value="Saqf">Saqf</option>
            <option value="Sarar">Sarar</option>
            <option value="Sarat Obeida">Sarat Obeida</option>
            <option value="Satorp (Jubail Ind'l 2)">Satorp (Jubail Ind'l 2)</option>
            <option value="Seihat">Seihat</option>
            <option value="Shaqra">Shaqra</option>
            <option value="Shari">Shari</option>
            <option value="Sharourah">Sharourah</option>
            <option value="Shefa'a">Shefa'a</option>
            <option value="Shinanh">Shinanh</option>
            <option value="Shoaiba">Shoaiba</option>
            <option value="Shraie'e">Shraie'e</option>
            <option value="Shumeisi">Shumeisi</option>
            <option value="Siir">Siir</option>
            <option value="Simira">Simira</option>
            <option value="Subheka">Subheka</option>
            <option value="Sulaiyl">Sulaiyl</option>
            <option value="Suwayr">Suwayr</option>
            <option value="Tablah">Tablah</option>
            <option value="Tabrjal">Tabrjal</option>
            <option value="Tabuk">Tabuk</option>
            <option value="Taiba">Taiba</option>
            <option value="Taif">Taif</option>
            <option value="Tanda">Tanda</option>
            <option value="Tanjeeb">Tanjeeb</option>
            <option value="Tanuma">Tanuma</option>
            <option value="Tanumah">Tanumah</option>
            <option value="Tarut">Tarut</option>
            <option value="Tatleeth">Tatleeth</option>
            <option value="Tayma">Tayma</option>
            <option value="Tebrak">Tebrak</option>
            <option value="Thabya">Thabya</option>
            <option value="Thadek">Thadek</option>
            <option value="Tharmada">Tharmada</option>
            <option value="Thebea">Thebea</option>
            <option value="Thumair">Thumair</option>
            <option value="Thuqba">Thuqba</option>
            <option value="Towal">Towal</option>
            <option value="Turaib">Turaib</option>
            <option value="Turaif">Turaif</option>
            <option value="Turba">Turba</option>
            <option value="Udhaliyah">Udhaliyah</option>
            <option value="Um Aljamajim">Um Aljamajim</option>
            <option value="Umluj">Umluj</option>
            <option value="Uqlat Al Suqur">Uqlat Al Suqur</option>
            <option value="Ushayqir">Ushayqir</option>
            <option value="Uyun">Uyun</option>
            <option value="Wadeien">Wadeien</option>
            <option value="Wadi Bin Hasbal">Wadi Bin Hasbal</option>
            <option value="Wadi El Dwaser">Wadi El Dwaser</option>
            <option value="Wadi Faraah">Wadi Faraah</option>
            <option value="Wadi Fatmah">Wadi Fatmah</option>
            <option value="Wajeh (Al Wajh)">Wajeh (Al Wajh)</option>
            <option value="Yanbu">Yanbu</option>
            <option value="Yanbu Al Baher">Yanbu Al Baher</option>
            <option value="Yanbu Nakhil">Yanbu Nakhil</option>
            <option value="Yuthma">Yuthma</option>
            <option value="Zallum">Zallum</option>
            <option value="Zulfi">Zulfi</option> 
        			</select>    
        		</div>
              
             <!--   <div class="form-group">-->
        					    
        					<!--	{!! Form::label('ships_zone', __('sale.aramexshipfrom') . ':') !!}-->
        			
        					<!--	<select name="aramexshipfrom" class="shipment_id form-control select2">-->
        				
        					<!--	    <option value="">Select</option>-->
        					<!--	    <option value="Ain Shams">Ain shams</option> -->
        					<!--	    <option value="El Salam City">Al salam</option>-->
        					<!--	    <option value="Al Marg">El marg</option>-->
        					<!--	    <option value="Heliopolis">Heliopolis</option>-->
        					<!--	    <option value="Atfeah">Atfeah</option> -->
        					<!--	    <option value="Nasr City">Nasr city</option>-->
        					<!--	    <option value="Zamalek">Zamalek</option>-->
        					<!--	    <option value="El Zeitoun">El Zeitoun</option>-->
        					<!--	    <option value="Mokattam">Mokattam</option>-->
        					<!--	    <option value="Torah">Torah</option>-->
        					<!--	    <option value="Moustorod">Moustorod</option>-->
        					<!--	    <option value="Meet Ghamr">Meet Ghamr</option>-->
        					<!--	    <option value="Badr City">Badr City</option>-->
        					<!--	    <option value="Boulak">Boulak</option>-->
        		   <!--                 <option value="Qasr elneil">Qasr elneil</option> -->
        					<!--	    <option value="Marsa Matrouh">Marsa Matrouh</option>-->
        					<!--	    <option value="Marinah">Marinah</option>-->
        					<!--	    <option value="Attaba">Attaba</option>-->
        					<!--	    <option value="Kasr El Einy">Kasr El Einy</option>-->
        					<!--	    <option value="Hadayek El Qobah">Hadayek El Qobah</option>-->
        					<!--	    <option value="15 Of May City">15th may</option>-->
        					<!--	    <option value="Helwan">Helwan</option>-->
        					<!--	    <option value="EL GOUNA">EL GOUNA</option>-->
        					<!--	    <option value="Maadi">Maadi</option>-->
        					<!--	    <option value="Madinaty">Madinaty</option> -->
        					<!--	    <option value="Manial El Rodah">Manial</option>-->
        					<!--	    <option value="Taba City">Taba City</option>-->
        					<!--	    <option value="New Cairo">New cairo</option>-->
        					<!--	    <option value="Al Shorouk">El shourok</option>-->
        					<!--	   <option value="Shoubra">Shoubra</option> -->
        					<!--	    <option value="Mansheyt Naser">Mansheyt Naser</option>-->
        					<!--	    <option value="Ramsis">Ramsis</option>-->
        					<!--	    <option value="RAS GHAREB">RAS GHAREB</option>-->
        					<!--	    <option value="El Hawamdiah">El Hawamdiah</option> -->
        					<!--	    <option value="Badrashin">Badrashin</option>-->
        					<!--	    <option value="Tebin">Tebin</option>-->
        					<!--	    <option value="El Ayat">El Ayat</option>-->
        					<!--	    <option value="El Saf">El Saf</option>-->
        					<!--	   <option value="Ghamrah">Ghamrah</option> -->
        					<!--	    <option value="Abu Zaabal">Abu Zaabal</option>-->
        					<!--	    <option value="Abasya">Abasya</option>-->
        					<!--	    <option value="Ras Seidr">Ras Seidr</option>-->
        					<!--	    <option value="Shebin El Koum">Shebin El Koum</option>-->
        					<!--	   <option value="Al Matarya">Al Matarya</option> -->
        					<!--	    <option value="Shubra">Shubra</option>-->
        					<!--	    <option value="Shubra El Kheima">Shoubra el khaima</option>-->
        					<!--	   <option value="Al Obour City">Al obor</option> -->
        					<!--	    <option value="10Th Of Ramadan City">10 of ramadan</option>-->
        					<!--	    <option value="Katamiah">Katamiah</option>-->
        					<!--	    <option value="Garden City">Garden City</option>-->
        					<!--	   <option value="Al Nobariah">Al Nobariah</option> -->
        					<!--	    <option value="Sadat City">Sadat City</option>-->
        					<!--	    <option value="Giza">Giza</option>-->
        					<!--	    <option value="Al Monib">Munib</option>-->
        					<!--	    <option value="Safaga">Safaga</option>-->
        					<!--	   <option value="EL rehab">EL rehab</option> -->
        					<!--	    <option value="Saqara">Saqara</option>-->
        					<!--	    <option value="Nuwibaa">Nuwibaa</option>-->
        					<!--	    <option value="Abo Rawash">Abou rawash</option>-->
        					<!--	   <option value="Agouza">Agouza</option> -->
        					<!--	    <option value="Dokki">Dokki</option>-->
        					<!--	    <option value="Marsa Alam">Marsa Alam</option>-->
        					<!--	    <option value="New Capital City">New Capital City</option>-->
        					<!--	    <option value="Al Haram">Haram</option>-->
        					<!--	   <option value="Imbaba">Imbaba</option> -->
        					<!--	    <option value="Mohandiseen">Mohandseen</option>-->
        					<!--	    <option value="October City">6th of Oct</option>-->
        					<!--	    <option value="Sheikh Zayed">Sheikh Zayed</option>-->
        					<!--	    <option value="Omranya">Omranyea</option>-->
        					<!--	   <option value="Al Waraq">Warraq</option> -->
        					<!--	    <option value="Alexandria">Alexandria</option>-->
        					<!--	    <option value="Assiut">Asuit</option>-->
        					<!--	    <option value="Aswan">Aswan</option>-->
        					<!--	    <option value="Damanhour">Damanhour</option>-->
        					<!--	   <option value="Bani Swif">Bani suef</option> -->
        					<!--	    <option value="Mansoura">Mansoura</option>-->
        					<!--	    <option value="Dumiatta">Damita</option>-->
        					<!--	    <option value="Fayoum">Fayoum</option>-->
        					<!--	    <option value="Al Mahala">Gharbya</option>-->
        					<!--	   <option value="Ismailia">Ismalya</option> -->
        					<!--	    <option value="Kafr Al Sheikh">Kafr elsheigh</option>-->
        					<!--	    <option value="Luxour">Luxour</option>-->
        					<!--	   <option value="Marsa Matrouh">Marsa Matrouh</option>-->
        					<!--	    <option value="Menia City">Minya</option>-->
        					<!--	    <option value="Al Menofiah">Al Menofiah</option>-->
        					<!--	    <option value="El Wadi El Gadid">El Wadi El Gadid</option>-->
        					<!--	   <option value="Wadi El Natroun">Wadi El Natroun</option> -->
        					<!--	    <option value="Port Said">Port said</option>-->
        					<!--	    <option value="Qaliubia">Qalyoubya</option>-->
        					<!--	    <option value="Qena">Qena</option>-->
        					<!--	    <option value="Sharm El Sheikh">Sharm El Sheikh</option>-->
        					<!--	   <option value="Zakazik">Zakazik</option> -->
        					<!--	    <option value="sohag City">Sohag</option>-->
        					<!--	    <option value="AL Qanater">AL Qanater</option>-->
        					<!--	   <option value="Suez">Suez</option>-->
        					<!--	    <option value="Siwa">Siwa</option>-->
        					<!--	</select>-->
        						
        					<!--</div>-->
              
              @endif
              
            @if($sshipment->name == "Abs/Api")
              <div class="form-group">
                {!! Form::label('abs_user', __( 'sale.abs user' ) . ':*') !!}
                  {!! Form::text('abs_user', $siting->abs_user, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.abs user' ) ]); !!}
              </div>
              <div class="form-group">
                  {!! Form::label('abs_password', __( 'sale.abs password' ) . ':*') !!}
                   {!! Form::text('abs_password', $siting->abs_password, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.abs password' ) ]); !!}
               </div>
               @endif
              
               @if($sshipment->name == "Mylerz/Api")
              <div class="form-group">
                {!! Form::label('mylerz_user', __( 'sale.mylerz user' ) . ':*') !!}
                  {!! Form::text('mylerz_user', $siting->mylerz_user, ['class' => 'form-control', 'required', 'placeholder' => __( 'ale.mylerz user' ) ]); !!}
              </div>
               <div class="form-group">
                  {!! Form::label('mylerz_password', __( 'sale.myerz password' ) . ':*') !!}
                  {!! Form::text('mylerz_password', $siting->mylerz_password, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.myerz password' ) ]); !!}
              </div>
              @endif
        
                <!--Voo Shipment -->
                @if ($sshipment->name == 'Voo/Api')
                    <div class="form-group">
                        {!! Form::label('mylerz_user', 'Voo User Token'. ' : * ') !!}
                        {!! Form::text('voo', $siting->voo ,['class' => 'form-control']) !!}
                    </div>
                @endif
                <!--Voo Shipment -->
                
                <!--XTURBO Shipment-->
                @if($sshipment->name == 'XTURBO/API')
                    @if(! empty($siting->xturbo_settings))
                        @php
                            $xturboSettings = json_decode($siting->xturbo_settings);
                            $pickupCity  = $xturboSettings->pickupCity;
                            $pickupAddress = $xturboSettings->pickupAddress;
                        @endphp
                    @else
                        @php
                            $pickupCity  = '';
                            $pickupAddress = null;
                        @endphp
                    @endif
                    <div class="form-group">
                        {!! Form::label('email', 'Email Account : *')!!}
                        {!! Form::text('xturbo_email',$siting->xturbo_email,['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('password', 'Password Account : *') !!}
                        {!! Form::text('xturbo_password',$siting->xturbo_password, [ 'class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('pickupAddress', __('sale.store_address'). ' : *')!!}
                        {!! Form::text('xturbo_pickupAddress',$pickupAddress,['class' => 'form-control']) !!}
                    </div>
                    <div class = "form-group">
                        {!! Form::label('xturbo_zone', __('sale.xturbo_zone') . ' :') !!}
                        <select name="xturbo_pickupCity" class="shipment_id form-control select2" id="xtrubocities">
                            <option value="">Select</option>
                        </select>
                    </div>
                @endif
                <!--end-->
              <button type="submit" class="main-dark-btn-lg">@lang( 'messages.update' )</button>
          
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</section>

@endsection
@section('javascript')
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready( function () {
            $('select#aramex_country').on('change','',function(e){
                const country = $('option:selected',this);
                const countryValue = this.value;
                showAramexAreas(countryValue);
          
            });
            $('#trafic_table').DataTable();
        });
    </script>
    <!--Zayed 23 / Feb / 2022-->
    <script>
        /*
    * this function make ajax request to get xturbo cities
    * Mostafa Zayed 17 / Feb / 2022
    * @return object cities
    */
    function getXturboCities()
    {
        $.ajax({
            url: "{{url('/shipment/xtrubo/cities')}}",
            type: 'GET',
            success: function(cities) {
                let xturboSelect = $('select#xtrubocities');
                if (cities.length > 0){
                    for (let step = 0; step < cities.length; step++){
                        xturboSelect.append($('<option>',{
                            value: cities[step].id,
                            text: cities[step].name_ar
                        }));
                    }
                } else {
                    alert('No Cities Founded From Xturbo Shipment Company');
                }
               
                let pickupCity = "{{$pickupCity}}";
                let cityOption = $('select#xtrubocities option');
                cityOption.filter('[value='+pickupCity+']').attr('selected',true);
            }
        });
    }
     function showAramexAreas(countryName)
    {
        if (countryName == 'EG') {
            
            $('div#egyptAreas > select').attr('name','aramexshipfrom');
            $('div#egyptAreas').show();
            $('div#saudiAreas > select').attr('name','');
            $('div#saudiAreas').hide();
            
        } else if(countryName == 'SA') {
            $('div#saudiAreas > select').attr('name','aramexshipfrom');
            $('div#saudiAreas').show();
            $('div#egyptAreas > select').attr('name','');
            $('div#egyptAreas').hide();
            
        }
    }
    
    getXturboCities();
    </script>
    
@endsection