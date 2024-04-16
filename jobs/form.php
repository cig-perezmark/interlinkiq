<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase addJobTitle">Add New Job</span>
            <span class="caption-subject font-red-sunglo bold uppercase editJobTitle">Update Job</span>
            <!-- <span class="caption-helper">form actions without bg color</span> -->
        </div>
        <div class="actions">
            <div class="portlet-input input-inline input-small">
                <div class="input-icon right">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
            </div>
        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form  method="post" class="form-horizontal AddJobForm " id="addjobform">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">Job Title</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="jobtitle" placeholder="Enter Job Title">
                        <!-- <span class="help-block"> A block of help text. </span> -->
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Description</label>
                    <div class="col-md-8">
                        <textarea class="form-control" rows="3" id="jobdescription"></textarea>
                    </div>
                </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Skills</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control input-large" id="jobskills" data-role="tagsinput"> 
                            <p><small>(Hit enter to add new entry)</small></p>
                        </div>
                    </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Empoyment Status</label>
                    <div class="col-md-8">
                        <select class="bs-select form-control" id="jobstatus">
                            <option value="0">Part Time</option>
                            <option value="1">Full Time</option>
                            <option value="2">Freelance</option>
                        </select>
                    </div>
                </div>
                <!-- <div class="form-group">
                    <label class="col-sm-3 control-label">Country Auto Complete</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-search"></i>
                            </span>
                            <input type="text" id="typeahead_example_2" name="typeahead_example_2" class="form-control" /> </div>
                        <p class="help-block"> E.g: USA, Malaysia. Prefetch from JSON source</code>
                        </p>
                    </div>
                </div> -->
                <!-- <div class="form-group">
                    <label class="control-label col-md-3">Location</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="location" placeholder="Type address..." />
                        <input type="checkbox" id="isworldwide" class="md-check">
                        <label for="checkbox1">
                        <span></span>
                        <span class="check"></span>
                        <span class="box"></span> Worldwide?</label>
                    </div>

                </div> -->
                <div class="form-group">
                    <label class="control-label col-md-3">Location</label>
                    <div class="col-md-4">
                        <input type="checkbox" id="isworldwide" class="md-check">
                        <label for="checkbox1">
                        <span></span>
                        <span class="check"></span>
                        <span class="box"></span> Worldwide?</label>
                        <select class="bs-select form-control" id="addlocation" data-live-search="true" data-size="8">
                                                        <option value="AF">Afghanistan</option>
                                                        <option value="AL">Albania</option>
                                                        <option value="DZ">Algeria</option>
                                                        <option value="AS">American Samoa</option>
                                                        <option value="AD">Andorra</option>
                                                        <option value="AO">Angola</option>
                                                        <option value="AI">Anguilla</option>
                                                        <option value="AR">Argentina</option>
                                                        <option value="AM">Armenia</option>
                                                        <option value="AW">Aruba</option>
                                                        <option value="AU">Australia</option>
                                                        <option value="AT">Austria</option>
                                                        <option value="AZ">Azerbaijan</option>
                                                        <option value="BS">Bahamas</option>
                                                        <option value="BH">Bahrain</option>
                                                        <option value="BD">Bangladesh</option>
                                                        <option value="BB">Barbados</option>
                                                        <option value="BY">Belarus</option>
                                                        <option value="BE">Belgium</option>
                                                        <option value="BZ">Belize</option>
                                                        <option value="BJ">Benin</option>
                                                        <option value="BM">Bermuda</option>
                                                        <option value="BT">Bhutan</option>
                                                        <option value="BO">Bolivia</option>
                                                        <option value="BA">Bosnia and Herzegowina</option>
                                                        <option value="BW">Botswana</option>
                                                        <option value="BV">Bouvet Island</option>
                                                        <option value="BR">Brazil</option>
                                                        <option value="IO">British Indian Ocean Territory</option>
                                                        <option value="BN">Brunei Darussalam</option>
                                                        <option value="BG">Bulgaria</option>
                                                        <option value="BF">Burkina Faso</option>
                                                        <option value="BI">Burundi</option>
                                                        <option value="KH">Cambodia</option>
                                                        <option value="CM">Cameroon</option>
                                                        <option value="CA">Canada</option>
                                                        <option value="CV">Cape Verde</option>
                                                        <option value="KY">Cayman Islands</option>
                                                        <option value="CF">Central African Republic</option>
                                                        <option value="TD">Chad</option>
                                                        <option value="CL">Chile</option>
                                                        <option value="CN">China</option>
                                                        <option value="CX">Christmas Island</option>
                                                        <option value="CC">Cocos (Keeling) Islands</option>
                                                        <option value="CO">Colombia</option>
                                                        <option value="KM">Comoros</option>
                                                        <option value="CG">Congo</option>
                                                        <option value="CD">Congo, the Democratic Republic of the</option>
                                                        <option value="CK">Cook Islands</option>
                                                        <option value="CR">Costa Rica</option>
                                                        <option value="CI">Cote d'Ivoire</option>
                                                        <option value="HR">Croatia (Hrvatska)</option>
                                                        <option value="CU">Cuba</option>
                                                        <option value="CY">Cyprus</option>
                                                        <option value="CZ">Czech Republic</option>
                                                        <option value="DK">Denmark</option>
                                                        <option value="DJ">Djibouti</option>
                                                        <option value="DM">Dominica</option>
                                                        <option value="DO">Dominican Republic</option>
                                                        <option value="EC">Ecuador</option>
                                                        <option value="EG">Egypt</option>
                                                        <option value="SV">El Salvador</option>
                                                        <option value="GQ">Equatorial Guinea</option>
                                                        <option value="ER">Eritrea</option>
                                                        <option value="EE">Estonia</option>
                                                        <option value="ET">Ethiopia</option>
                                                        <option value="FK">Falkland Islands (Malvinas)</option>
                                                        <option value="FO">Faroe Islands</option>
                                                        <option value="FJ">Fiji</option>
                                                        <option value="FI">Finland</option>
                                                        <option value="FR">France</option>
                                                        <option value="GF">French Guiana</option>
                                                        <option value="PF">French Polynesia</option>
                                                        <option value="TF">French Southern Territories</option>
                                                        <option value="GA">Gabon</option>
                                                        <option value="GM">Gambia</option>
                                                        <option value="GE">Georgia</option>
                                                        <option value="DE">Germany</option>
                                                        <option value="GH">Ghana</option>
                                                        <option value="GI">Gibraltar</option>
                                                        <option value="GR">Greece</option>
                                                        <option value="GL">Greenland</option>
                                                        <option value="GD">Grenada</option>
                                                        <option value="GP">Guadeloupe</option>
                                                        <option value="GU">Guam</option>
                                                        <option value="GT">Guatemala</option>
                                                        <option value="GN">Guinea</option>
                                                        <option value="GW">Guinea-Bissau</option>
                                                        <option value="GY">Guyana</option>
                                                        <option value="HT">Haiti</option>
                                                        <option value="HM">Heard and Mc Donald Islands</option>
                                                        <option value="VA">Holy See (Vatican City State)</option>
                                                        <option value="HN">Honduras</option>
                                                        <option value="HK">Hong Kong</option>
                                                        <option value="HU">Hungary</option>
                                                        <option value="IS">Iceland</option>
                                                        <option value="IN">India</option>
                                                        <option value="ID">Indonesia</option>
                                                        <option value="IR">Iran (Islamic Republic of)</option>
                                                        <option value="IQ">Iraq</option>
                                                        <option value="IE">Ireland</option>
                                                        <option value="IL">Israel</option>
                                                        <option value="IT">Italy</option>
                                                        <option value="JM">Jamaica</option>
                                                        <option value="JP">Japan</option>
                                                        <option value="JO">Jordan</option>
                                                        <option value="KZ">Kazakhstan</option>
                                                        <option value="KE">Kenya</option>
                                                        <option value="KI">Kiribati</option>
                                                        <option value="KP">Korea, Democratic People's Republic of</option>
                                                        <option value="KR">Korea, Republic of</option>
                                                        <option value="KW">Kuwait</option>
                                                        <option value="KG">Kyrgyzstan</option>
                                                        <option value="LA">Lao People's Democratic Republic</option>
                                                        <option value="LV">Latvia</option>
                                                        <option value="LB">Lebanon</option>
                                                        <option value="LS">Lesotho</option>
                                                        <option value="LR">Liberia</option>
                                                        <option value="LY">Libyan Arab Jamahiriya</option>
                                                        <option value="LI">Liechtenstein</option>
                                                        <option value="LT">Lithuania</option>
                                                        <option value="LU">Luxembourg</option>
                                                        <option value="MO">Macau</option>
                                                        <option value="MK">Macedonia, The Former Yugoslav Republic of</option>
                                                        <option value="MG">Madagascar</option>
                                                        <option value="MW">Malawi</option>
                                                        <option value="MY">Malaysia</option>
                                                        <option value="MV">Maldives</option>
                                                        <option value="ML">Mali</option>
                                                        <option value="MT">Malta</option>
                                                        <option value="MH">Marshall Islands</option>
                                                        <option value="MQ">Martinique</option>
                                                        <option value="MR">Mauritania</option>
                                                        <option value="MU">Mauritius</option>
                                                        <option value="YT">Mayotte</option>
                                                        <option value="MX">Mexico</option>
                                                        <option value="FM">Micronesia, Federated States of</option>
                                                        <option value="MD">Moldova, Republic of</option>
                                                        <option value="MC">Monaco</option>
                                                        <option value="MN">Mongolia</option>
                                                        <option value="MS">Montserrat</option>
                                                        <option value="MA">Morocco</option>
                                                        <option value="MZ">Mozambique</option>
                                                        <option value="MM">Myanmar</option>
                                                        <option value="NA">Namibia</option>
                                                        <option value="NR">Nauru</option>
                                                        <option value="NP">Nepal</option>
                                                        <option value="NL">Netherlands</option>
                                                        <option value="AN">Netherlands Antilles</option>
                                                        <option value="NC">New Caledonia</option>
                                                        <option value="NZ">New Zealand</option>
                                                        <option value="NI">Nicaragua</option>
                                                        <option value="NE">Niger</option>
                                                        <option value="NG">Nigeria</option>
                                                        <option value="NU">Niue</option>
                                                        <option value="NF">Norfolk Island</option>
                                                        <option value="MP">Northern Mariana Islands</option>
                                                        <option value="NO">Norway</option>
                                                        <option value="OM">Oman</option>
                                                        <option value="PK">Pakistan</option>
                                                        <option value="PW">Palau</option>
                                                        <option value="PA">Panama</option>
                                                        <option value="PG">Papua New Guinea</option>
                                                        <option value="PY">Paraguay</option>
                                                        <option value="PE">Peru</option>
                                                        <option value="PH">Philippines</option>
                                                        <option value="PN">Pitcairn</option>
                                                        <option value="PL">Poland</option>
                                                        <option value="PT">Portugal</option>
                                                        <option value="PR">Puerto Rico</option>
                                                        <option value="QA">Qatar</option>
                                                        <option value="RE">Reunion</option>
                                                        <option value="RO">Romania</option>
                                                        <option value="RU">Russian Federation</option>
                                                        <option value="RW">Rwanda</option>
                                                        <option value="KN">Saint Kitts and Nevis</option>
                                                        <option value="LC">Saint LUCIA</option>
                                                        <option value="VC">Saint Vincent and the Grenadines</option>
                                                        <option value="WS">Samoa</option>
                                                        <option value="SM">San Marino</option>
                                                        <option value="ST">Sao Tome and Principe</option>
                                                        <option value="SA">Saudi Arabia</option>
                                                        <option value="SN">Senegal</option>
                                                        <option value="SC">Seychelles</option>
                                                        <option value="SL">Sierra Leone</option>
                                                        <option value="SG">Singapore</option>
                                                        <option value="SK">Slovakia (Slovak Republic)</option>
                                                        <option value="SI">Slovenia</option>
                                                        <option value="SB">Solomon Islands</option>
                                                        <option value="SO">Somalia</option>
                                                        <option value="ZA">South Africa</option>
                                                        <option value="GS">South Georgia and the South Sandwich Islands</option>
                                                        <option value="ES">Spain</option>
                                                        <option value="LK">Sri Lanka</option>
                                                        <option value="SH">St. Helena</option>
                                                        <option value="PM">St. Pierre and Miquelon</option>
                                                        <option value="SD">Sudan</option>
                                                        <option value="SR">Suriname</option>
                                                        <option value="SJ">Svalbard and Jan Mayen Islands</option>
                                                        <option value="SZ">Swaziland</option>
                                                        <option value="SE">Sweden</option>
                                                        <option value="CH">Switzerland</option>
                                                        <option value="SY">Syrian Arab Republic</option>
                                                        <option value="TW">Taiwan, Province of China</option>
                                                        <option value="TJ">Tajikistan</option>
                                                        <option value="TZ">Tanzania, United Republic of</option>
                                                        <option value="TH">Thailand</option>
                                                        <option value="TG">Togo</option>
                                                        <option value="TK">Tokelau</option>
                                                        <option value="TO">Tonga</option>
                                                        <option value="TT">Trinidad and Tobago</option>
                                                        <option value="TN">Tunisia</option>
                                                        <option value="TR">Turkey</option>
                                                        <option value="TM">Turkmenistan</option>
                                                        <option value="TC">Turks and Caicos Islands</option>
                                                        <option value="TV">Tuvalu</option>
                                                        <option value="UG">Uganda</option>
                                                        <option value="UA">Ukraine</option>
                                                        <option value="AE">United Arab Emirates</option>
                                                        <option value="GB">United Kingdom</option>
                                                        <option value="US">United States</option>
                                                        <option value="UM">United States Minor Outlying Islands</option>
                                                        <option value="UY">Uruguay</option>
                                                        <option value="UZ">Uzbekistan</option>
                                                        <option value="VU">Vanuatu</option>
                                                        <option value="VE">Venezuela</option>
                                                        <option value="VN">Viet Nam</option>
                                                        <option value="VG">Virgin Islands (British)</option>
                                                        <option value="VI">Virgin Islands (U.S.)</option>
                                                        <option value="WF">Wallis and Futuna Islands</option>
                                                        <option value="EH">Western Sahara</option>
                                                        <option value="YE">Yemen</option>
                                                        <option value="ZM">Zambia</option>
                                                        <option value="ZW">Zimbabwe</option>
                        </select>
                        <!-- <span>Country</span> -->
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Salary</label>
                    <div class="col-md-4">
                        <select class="bs-select form-control" id="jobsalary">
                            <option value="0">Based on Experience</option>
                            <option value="1">To be discussed</option>
                            <option value="2">Specific</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="specificSal" placeholder="Input Specific Salary">
                    </div>
                    <!-- <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Input salary if specific">
                    </div> -->
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn green" >Submit</button>
                        <button type="button" class="btn default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- END FORM-->

        <!-- Update Form -->
        <!-- BEGIN FORM-->
        <form  method="post" class="form-horizontal EditJobForm " id="editjobform">
            <input type="hidden" id="jobid" name="jobid" >
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">Job Title</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="edittitle" placeholder="Enter Job Title">
                        <!-- <span class="help-block"> A block of help text. </span> -->
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Description</label>
                    <div class="col-md-8">
                        <textarea class="form-control" rows="3" id="editdescription"></textarea>
                    </div>
                </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Skills</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control input-large"  id="editskills" data-role="tagsinput"> 
                            <p><small>(Hit enter to add new entry)</small></p>
                            <!-- <select multiple data-role="tagsinput">
                                <option value="Php">Php</option>
                                <option value="HTML">HTML</option>
                                <option value="CSS">CSS</option>
                                <option value="JS">JS</option>
                            </select> -->
                        </div>
                    </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Empoyment Status</label>
                    <div class="col-md-8">
                        <select class="bs-select form-control" id="editstatus">
                            <option value="0">Part Time</option>
                            <option value="1">Full Time</option>
                            <option value="2">Freelance</option>
                        </select>
                    </div>
                </div>
                <!-- <div class="form-group">
                    <label class="col-sm-3 control-label">Country Auto Complete</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-search"></i>
                            </span>
                            <input type="text" id="typeahead_example_2" name="typeahead_example_2" class="form-control" /> </div>
                        <p class="help-block"> E.g: USA, Malaysia. Prefetch from JSON source</code>
                        </p>
                    </div>
                </div> -->
                <!-- <div class="form-group">
                    <label class="control-label col-md-3">Location</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="location" placeholder="Type address..." />
                        <input type="checkbox" id="isworldwide" class="md-check">
                        <label for="checkbox1">
                        <span></span>
                        <span class="check"></span>
                        <span class="box"></span> Worldwide?</label>
                    </div>

                </div> -->
                <div class="form-group">
                    <label class="control-label col-md-3">Location</label>
                    <div class="col-md-4">
                        <input type="checkbox" id="editworldwide" class="md-check">
                        <label for="checkbox1">
                        <span></span>
                        <span class="check"></span>
                        <span class="box"></span> Worldwide?</label>
                        <select class="bs-select form-control" id="editlocation" data-live-search="true" data-size="8">
                                                        <option value="AF">Afghanistan</option>
                                                        <option value="AL">Albania</option>
                                                        <option value="DZ">Algeria</option>
                                                        <option value="AS">American Samoa</option>
                                                        <option value="AD">Andorra</option>
                                                        <option value="AO">Angola</option>
                                                        <option value="AI">Anguilla</option>
                                                        <option value="AR">Argentina</option>
                                                        <option value="AM">Armenia</option>
                                                        <option value="AW">Aruba</option>
                                                        <option value="AU">Australia</option>
                                                        <option value="AT">Austria</option>
                                                        <option value="AZ">Azerbaijan</option>
                                                        <option value="BS">Bahamas</option>
                                                        <option value="BH">Bahrain</option>
                                                        <option value="BD">Bangladesh</option>
                                                        <option value="BB">Barbados</option>
                                                        <option value="BY">Belarus</option>
                                                        <option value="BE">Belgium</option>
                                                        <option value="BZ">Belize</option>
                                                        <option value="BJ">Benin</option>
                                                        <option value="BM">Bermuda</option>
                                                        <option value="BT">Bhutan</option>
                                                        <option value="BO">Bolivia</option>
                                                        <option value="BA">Bosnia and Herzegowina</option>
                                                        <option value="BW">Botswana</option>
                                                        <option value="BV">Bouvet Island</option>
                                                        <option value="BR">Brazil</option>
                                                        <option value="IO">British Indian Ocean Territory</option>
                                                        <option value="BN">Brunei Darussalam</option>
                                                        <option value="BG">Bulgaria</option>
                                                        <option value="BF">Burkina Faso</option>
                                                        <option value="BI">Burundi</option>
                                                        <option value="KH">Cambodia</option>
                                                        <option value="CM">Cameroon</option>
                                                        <option value="CA">Canada</option>
                                                        <option value="CV">Cape Verde</option>
                                                        <option value="KY">Cayman Islands</option>
                                                        <option value="CF">Central African Republic</option>
                                                        <option value="TD">Chad</option>
                                                        <option value="CL">Chile</option>
                                                        <option value="CN">China</option>
                                                        <option value="CX">Christmas Island</option>
                                                        <option value="CC">Cocos (Keeling) Islands</option>
                                                        <option value="CO">Colombia</option>
                                                        <option value="KM">Comoros</option>
                                                        <option value="CG">Congo</option>
                                                        <option value="CD">Congo, the Democratic Republic of the</option>
                                                        <option value="CK">Cook Islands</option>
                                                        <option value="CR">Costa Rica</option>
                                                        <option value="CI">Cote d'Ivoire</option>
                                                        <option value="HR">Croatia (Hrvatska)</option>
                                                        <option value="CU">Cuba</option>
                                                        <option value="CY">Cyprus</option>
                                                        <option value="CZ">Czech Republic</option>
                                                        <option value="DK">Denmark</option>
                                                        <option value="DJ">Djibouti</option>
                                                        <option value="DM">Dominica</option>
                                                        <option value="DO">Dominican Republic</option>
                                                        <option value="EC">Ecuador</option>
                                                        <option value="EG">Egypt</option>
                                                        <option value="SV">El Salvador</option>
                                                        <option value="GQ">Equatorial Guinea</option>
                                                        <option value="ER">Eritrea</option>
                                                        <option value="EE">Estonia</option>
                                                        <option value="ET">Ethiopia</option>
                                                        <option value="FK">Falkland Islands (Malvinas)</option>
                                                        <option value="FO">Faroe Islands</option>
                                                        <option value="FJ">Fiji</option>
                                                        <option value="FI">Finland</option>
                                                        <option value="FR">France</option>
                                                        <option value="GF">French Guiana</option>
                                                        <option value="PF">French Polynesia</option>
                                                        <option value="TF">French Southern Territories</option>
                                                        <option value="GA">Gabon</option>
                                                        <option value="GM">Gambia</option>
                                                        <option value="GE">Georgia</option>
                                                        <option value="DE">Germany</option>
                                                        <option value="GH">Ghana</option>
                                                        <option value="GI">Gibraltar</option>
                                                        <option value="GR">Greece</option>
                                                        <option value="GL">Greenland</option>
                                                        <option value="GD">Grenada</option>
                                                        <option value="GP">Guadeloupe</option>
                                                        <option value="GU">Guam</option>
                                                        <option value="GT">Guatemala</option>
                                                        <option value="GN">Guinea</option>
                                                        <option value="GW">Guinea-Bissau</option>
                                                        <option value="GY">Guyana</option>
                                                        <option value="HT">Haiti</option>
                                                        <option value="HM">Heard and Mc Donald Islands</option>
                                                        <option value="VA">Holy See (Vatican City State)</option>
                                                        <option value="HN">Honduras</option>
                                                        <option value="HK">Hong Kong</option>
                                                        <option value="HU">Hungary</option>
                                                        <option value="IS">Iceland</option>
                                                        <option value="IN">India</option>
                                                        <option value="ID">Indonesia</option>
                                                        <option value="IR">Iran (Islamic Republic of)</option>
                                                        <option value="IQ">Iraq</option>
                                                        <option value="IE">Ireland</option>
                                                        <option value="IL">Israel</option>
                                                        <option value="IT">Italy</option>
                                                        <option value="JM">Jamaica</option>
                                                        <option value="JP">Japan</option>
                                                        <option value="JO">Jordan</option>
                                                        <option value="KZ">Kazakhstan</option>
                                                        <option value="KE">Kenya</option>
                                                        <option value="KI">Kiribati</option>
                                                        <option value="KP">Korea, Democratic People's Republic of</option>
                                                        <option value="KR">Korea, Republic of</option>
                                                        <option value="KW">Kuwait</option>
                                                        <option value="KG">Kyrgyzstan</option>
                                                        <option value="LA">Lao People's Democratic Republic</option>
                                                        <option value="LV">Latvia</option>
                                                        <option value="LB">Lebanon</option>
                                                        <option value="LS">Lesotho</option>
                                                        <option value="LR">Liberia</option>
                                                        <option value="LY">Libyan Arab Jamahiriya</option>
                                                        <option value="LI">Liechtenstein</option>
                                                        <option value="LT">Lithuania</option>
                                                        <option value="LU">Luxembourg</option>
                                                        <option value="MO">Macau</option>
                                                        <option value="MK">Macedonia, The Former Yugoslav Republic of</option>
                                                        <option value="MG">Madagascar</option>
                                                        <option value="MW">Malawi</option>
                                                        <option value="MY">Malaysia</option>
                                                        <option value="MV">Maldives</option>
                                                        <option value="ML">Mali</option>
                                                        <option value="MT">Malta</option>
                                                        <option value="MH">Marshall Islands</option>
                                                        <option value="MQ">Martinique</option>
                                                        <option value="MR">Mauritania</option>
                                                        <option value="MU">Mauritius</option>
                                                        <option value="YT">Mayotte</option>
                                                        <option value="MX">Mexico</option>
                                                        <option value="FM">Micronesia, Federated States of</option>
                                                        <option value="MD">Moldova, Republic of</option>
                                                        <option value="MC">Monaco</option>
                                                        <option value="MN">Mongolia</option>
                                                        <option value="MS">Montserrat</option>
                                                        <option value="MA">Morocco</option>
                                                        <option value="MZ">Mozambique</option>
                                                        <option value="MM">Myanmar</option>
                                                        <option value="NA">Namibia</option>
                                                        <option value="NR">Nauru</option>
                                                        <option value="NP">Nepal</option>
                                                        <option value="NL">Netherlands</option>
                                                        <option value="AN">Netherlands Antilles</option>
                                                        <option value="NC">New Caledonia</option>
                                                        <option value="NZ">New Zealand</option>
                                                        <option value="NI">Nicaragua</option>
                                                        <option value="NE">Niger</option>
                                                        <option value="NG">Nigeria</option>
                                                        <option value="NU">Niue</option>
                                                        <option value="NF">Norfolk Island</option>
                                                        <option value="MP">Northern Mariana Islands</option>
                                                        <option value="NO">Norway</option>
                                                        <option value="OM">Oman</option>
                                                        <option value="PK">Pakistan</option>
                                                        <option value="PW">Palau</option>
                                                        <option value="PA">Panama</option>
                                                        <option value="PG">Papua New Guinea</option>
                                                        <option value="PY">Paraguay</option>
                                                        <option value="PE">Peru</option>
                                                        <option value="PH">Philippines</option>
                                                        <option value="PN">Pitcairn</option>
                                                        <option value="PL">Poland</option>
                                                        <option value="PT">Portugal</option>
                                                        <option value="PR">Puerto Rico</option>
                                                        <option value="QA">Qatar</option>
                                                        <option value="RE">Reunion</option>
                                                        <option value="RO">Romania</option>
                                                        <option value="RU">Russian Federation</option>
                                                        <option value="RW">Rwanda</option>
                                                        <option value="KN">Saint Kitts and Nevis</option>
                                                        <option value="LC">Saint LUCIA</option>
                                                        <option value="VC">Saint Vincent and the Grenadines</option>
                                                        <option value="WS">Samoa</option>
                                                        <option value="SM">San Marino</option>
                                                        <option value="ST">Sao Tome and Principe</option>
                                                        <option value="SA">Saudi Arabia</option>
                                                        <option value="SN">Senegal</option>
                                                        <option value="SC">Seychelles</option>
                                                        <option value="SL">Sierra Leone</option>
                                                        <option value="SG">Singapore</option>
                                                        <option value="SK">Slovakia (Slovak Republic)</option>
                                                        <option value="SI">Slovenia</option>
                                                        <option value="SB">Solomon Islands</option>
                                                        <option value="SO">Somalia</option>
                                                        <option value="ZA">South Africa</option>
                                                        <option value="GS">South Georgia and the South Sandwich Islands</option>
                                                        <option value="ES">Spain</option>
                                                        <option value="LK">Sri Lanka</option>
                                                        <option value="SH">St. Helena</option>
                                                        <option value="PM">St. Pierre and Miquelon</option>
                                                        <option value="SD">Sudan</option>
                                                        <option value="SR">Suriname</option>
                                                        <option value="SJ">Svalbard and Jan Mayen Islands</option>
                                                        <option value="SZ">Swaziland</option>
                                                        <option value="SE">Sweden</option>
                                                        <option value="CH">Switzerland</option>
                                                        <option value="SY">Syrian Arab Republic</option>
                                                        <option value="TW">Taiwan, Province of China</option>
                                                        <option value="TJ">Tajikistan</option>
                                                        <option value="TZ">Tanzania, United Republic of</option>
                                                        <option value="TH">Thailand</option>
                                                        <option value="TG">Togo</option>
                                                        <option value="TK">Tokelau</option>
                                                        <option value="TO">Tonga</option>
                                                        <option value="TT">Trinidad and Tobago</option>
                                                        <option value="TN">Tunisia</option>
                                                        <option value="TR">Turkey</option>
                                                        <option value="TM">Turkmenistan</option>
                                                        <option value="TC">Turks and Caicos Islands</option>
                                                        <option value="TV">Tuvalu</option>
                                                        <option value="UG">Uganda</option>
                                                        <option value="UA">Ukraine</option>
                                                        <option value="AE">United Arab Emirates</option>
                                                        <option value="GB">United Kingdom</option>
                                                        <option value="US">United States</option>
                                                        <option value="UM">United States Minor Outlying Islands</option>
                                                        <option value="UY">Uruguay</option>
                                                        <option value="UZ">Uzbekistan</option>
                                                        <option value="VU">Vanuatu</option>
                                                        <option value="VE">Venezuela</option>
                                                        <option value="VN">Viet Nam</option>
                                                        <option value="VG">Virgin Islands (British)</option>
                                                        <option value="VI">Virgin Islands (U.S.)</option>
                                                        <option value="WF">Wallis and Futuna Islands</option>
                                                        <option value="EH">Western Sahara</option>
                                                        <option value="YE">Yemen</option>
                                                        <option value="ZM">Zambia</option>
                                                        <option value="ZW">Zimbabwe</option>
                        </select>
                        <span>Country</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Salary</label>
                    <div class="col-md-4">
                        <select class="bs-select form-control" id="editsalary">
                            <option value="0">Based on Experience</option>
                            <option value="1">To be discussed</option>
                            <option value="2">Specific</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="especificSal" placeholder="Input Specific Salary">
                    </div>
                    <!-- <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Input salary if specific">
                    </div> -->
                </div>
            </div>
            <div class="form-actions addButton">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn green" >Submit</button>
                        <button type="button" class="btn default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
            <div class="form-actions editButtons">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn green" >Save Changes</button>
                        <button type="button" class="btn default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
 var hasUser=false;
 var isNew=false;
    $(document).ready(function(){
        // fetchAllData();
        $(".editButton").hide();
        $(".applyBtn").hide();
        $("#specificSal").hide();
         $('.actionBar').hide();
        getUserData();
        $(".job-card").mouseover(function(e) {
            $(this).css("box-shadow", "0 0 11px rgba(33, 33, 33, 0.2)");
            if (e.type == 'mouseover'){
                var index = $(".job-card").index(this);
                $('.editButton').eq(index).show();
            }
        
        }).mouseleave(function(e){
            $(this).css("box-shadow", "0px 0px 0px rgba(33, 33, 33, 0.2)");
            $(".editButton").hide();

        });
        $( "#addjobform" ).submit(function(e) {
            e.preventDefault();
            var jobtitle=$('#jobtitle').val();
            var jobdescription=$('#jobdescription').val();
            var jobskills=$('#jobskills').val();
            var jobstatus=$('#jobstatus').val();
            var location=null;
            var isworldwide=null;
            var jobsalary=$('#jobsalary').val();
            if ($('input#isworldwide').is(':checked')) {
                location="worldwide";
                // $('#location').hide();
                isworldwide=1
            }
            else{
            location=$("#addlocation").val();
            isworldwide=0;
            }
            if(jobtitle==""||jobdescription==""||jobskills==""){
                 alert("Some fields are empty please check your input data first");
            }
            else{
            var data=$(this).serialize()+"jobtitle="+jobtitle+ "&jobdescription="+jobdescription+"&jobskills="+jobskills+"&jobstatus="+jobstatus+"&location="+location+"&isworldwide="+isworldwide+"&jobsalary="+jobsalary +"&save";
            $.ajax({
                type:   "POST",
                url:    "action.php",
                data:   data,
                dataType : "json",
                success: function(response){
                    console.log(response);

                }
            })
            clearForm(); 
            $('#modalJob').modal('hide');
            fetchAllDataWithUser();
            }
        });
        function clearForm(){
            $('#jobtitle').val('');
            $('#jobdescription').val('');
            $('#jobskills').val('');
            $('#jobstatus').val('');
            $("#addlocation").val('');
        }
        $(".addJobButton").click(function(e) {
            $(".EditJobForm").hide();
            $(".AddJobForm").show();     
            $(".addJobTitle").show();
            $(".editJobTitle").hide();
            $(".addButton").hide();
            $(".editButton").hide();
        });
        // $(document).on("submit","#editjobform",function() {
        $( "#editjobform" ).on("submit",function(e) {
            // alert("Edit Form");
            e.preventDefault();
            var id=$("#jobid").val();
            var jobtitle=$('#edittitle').val();
            var jobdescription=$('#editdescription').val();
            var jobskills=$('#editskills').val();
            var jobstatus=$('#editstatus').val();
            var location=null;
            var isworldwide=null;
            // var jobsalary=$('#editsalary').val();
            var jobsalary="";
            if($('#editsalary').val()==2){
                jobsalary=$("#especificSal").val();
            }
            else{
                jobsalary=$('#editsalary').val();
            }
            // alert(jobsalary);
            if ($('input#editworldwide').is(':checked')) {
                location="worldwide";
                isworldwide=1
            }
            else{
            location=$("#editlocation").val();
            isworldwide=0;
            }
            if(jobtitle==""||jobdescription==""||jobskills==""){
                alert("Some fields are empty please check your input data first");
            }
            else{
            var data=$(this).serialize()+"&jobtitle="+jobtitle+ "&jobdescription="+jobdescription+"&jobskills="+jobskills+"&jobstatus="+jobstatus+"&location="+location+"&isworldwide="+isworldwide+"&jobsalary="+jobsalary +"&edit";
            console.log(data);
            $.ajax({
                type:       "POST",
                url:        "action.php",
                data:       data,
                dataType :  "json",
                success: function(response){
                    console.log(response);

                }
            })
            clearForm(); 
            $('#modalJob').modal('hide');
            fetchAllDataWithUser();
            }

        });
        // Fetching country
        // Geonames API Free Version
        // $.ajax({
        //     type: "GET",
        //     url: "https://secure.geonames.org/countryInfo?username=jggumapo&type=json",
        //     dataType: "json",
        //     beforeSend: function (request) {
        //         request.withCredentials = false;
        //     },
        //     asyn: true,
        //     success: function(data){
        //         $.each(data.geonames, function(i){
        //             // console.log(data.geonames[i].countryName+data.geonames[i].countryCode);
        //             // getStates(data.geonames[i].geonameId)
        //         })
        //     }
        //     // city(admi3)->admi2->admi1(state)->country
        // });

        // //get state
        //     $.ajax({
        //     type: "GET",
        //     url: "https://secure.geonames.org/children?geonameId=7521309&username=jggumapo&hierarchy=geography&type=json",
        //     dataType: "json",
        //     beforeSend: function (request) {
        //         request.withCredentials = false;
        //     },
        //     asyn: true,
        //     success: function(data){
        //         $.each(data, function(i){
        //             console.log(data);
        //         })
        //     }
        //     // city(admi3)->admi2->admi1(state)->country
        // });
        
        // var datas=$(this).serialize()+ "&getUserType";
        // $.ajax({
        //     type: "POST",
        //     data: datas,
        //     url: "action.php",
        //     dataType: "text",
        //     success: function(data){
        //             console.log(data);
        //     }
        //     // city(admi3)->admi2->admi1(state)->country
        // });
        // fetchAllData();
        function fetchAllData(){
            var data=$(this).serialize()+ "&fetch";
            var displayJobs="";
            var setNew="";
            var displayTime="";
            $.ajax({
                type:   "POST",
                url:    "action.php",
                data:   data,
                dataType : "json",
                cache: false,
                success: function(data){                         
                    $.each(data, function(k,value){
                        displayTime=timeAgo(value.createdat);
                        if(isNew==false){
                            setNew="";
                        }
                        else{
                            setNew="new"
                        }
                        // console.log(isNew);
                        displayJobs+=   '<li class="job-card '+jobPost()+' featured">'+
                                            '<div class="job-card__info">'+
                                                ' <div class="d-md-flex align-items-center">'+
                                                    '<div class="img-c"><img src="http://projects.lollypop.design/job-listing/photosnap.svg"/></div>'+
                                                    '<div>'+
                                                        '<div class="d-flex align-items-center">'+
                                                            '<p>Photosnap</p>'+
                                                            '<p class="tag-new">New!</p>'+
                                                            '<p class="tag-featured">Featured</p>'+
                                                        '</div><a href="javascript:void(0)">'+
                                                        '<h6>'+value.title+'</h6></a>'+
                                                        '<ul>'+
                                                            '<li>'+displayTime+'</li>'+
                                                            '<li>'+status(value.status)+'</li>'+
                                                            '<li>'+country(value.location, value.isworldwide)+'</li>'+
                                                        '</ul>'+
                                                    '</div>'+
                                                '</div>'+
                                                '<div><button class="btn btn-dark applyBtn" data-id="'+value["id"]+'" data-uid="'+value["userId"]+'">Apply Now</button> </div>'+
                                            '</div>'+
                                            '<ul class="job-card__tags">'+
                                                split(value.skill)+
                                            '</ul>'+
                                        '</li>';
                        });
                    $('#job-list').html(displayJobs);                     
                }
                
             });
        }
         function fetchAllDataWithUser(){
            var data=$(this).serialize()+ "&fetchwithUser";
            var displayJobs="";
            var setNew="";
            var displayTime="";
            $.ajax({
                type:   "POST",
                url:    "action.php",
                data:   data,
                dataType : "json",
                cache: false,
                success: function(data){                         
                    $.each(data, function(k,value){
                        //  console.log(isNew+"is New");
                        displayTime=timeAgo(value.createdat);
                        if(isNew==false){
                            setNew="";
                        }
                        else{
                            setNew="new"
                        }
                        // console.log(isNew);
                        
                        displayJobs+=   '<li class="job-card '+setNew+' featured">'+
                                            '<div class="job-card__info">'+
                                                ' <div class="d-md-flex align-items-center">'+
                                                    '<div class="img-c"><img src="http://projects.lollypop.design/job-listing/photosnap.svg"/></div>'+
                                                    '<div>'+
                                                        '<div class="d-flex align-items-center">'+
                                                            '<p>Photosnap</p>'+
                                                            '<p class="tag-new">New!</p>'+
                                                            '<p class="tag-featured">Featured</p>'+
                                                        '</div><a href="javascript:void(0)">'+
                                                        '<h6>'+value.title+'</h6></a>'+
                                                        '<ul id="jobDetails">'+
                                                            '<li>'+displayTime+'</li>'+
                                                            '<li>'+status(value.status)+'</li>'+
                                                            '<li>'+country(value.location, value.isworldwide)+'</li>'+
                                                        '</ul>'+
                                                    '</div>'+
                                                '</div>'+
                                                '<div> <button  class="editButton btn btn-dark " data-id="'+value["id"]+'" data-toggle="modal" href="#modalJob">Edit</button> </div>'+
                                            '</div>'+
                                            '<ul class="job-card__tags">'+
                                                split(value.skill)+
                                            '</ul>'+
                                        '</li>';
                        });
                    $('#job-list').html(displayJobs);                     
                }
                
             });
        }
        //split comma from skills
        function split(data){
            var skillsDisplay="";
            var array = data.split(",");
            for (var i in array){
                skillsDisplay+='<li>'+array[i]+'</li>'
            }
            return skillsDisplay;
        }

        //employment status
        function status(value){
            var display="";
            if(value==0){
                display='Part Time';
            }
            else if(value==1){
                display='Full Time';
            }
            else if(value==2){
                display='Freelance';
            }
            return display;
        }
        //convert date created with timeago
        function timeAgo(date_time){
            var display
            var currentDate=Math.round(+new Date()/1000);
            var postedDate=Math.round(+new Date(date_time)/1000);
            var diffTime=currentDate-postedDate;
            if(diffTime<59)
            {
                display='less than a minute ago';
                isNew=true;
            }
            else if(diffTime>59 && diffTime<120){
                display='about a minute ago';
                isNew=true;
            }
            else if(diffTime>=121 && diffTime<=3600)
            {
                display=parseInt(diffTime/60).toString()+' minutes ago';
                isNew=true;
            }
            else if(diffTime>3600 && diffTime<7200){
                display='1 hour ago';
                isNew=true;
            }
            else if(diffTime>7200 && diffTime<86400){
                display=parseInt(diffTime/3600).toString()+' hours ago';
                isNew=true;
            }
            else if(diffTime>86400 && diffTime<172800){
                display='1 day ago';
                // console.log(diffTime);
                isNew=true;
            }
            else if(diffTime>172800 && diffTime<604800){
                display=parseInt(diffTime/86400).toString()+' days ago';
                isNew=true;
                
            }
            else if(diffTime>604800 && diffTime<12089600){
                display='1 week ago'
                isNew=true;
            }
            else if(diffTime>12089600 && diffTime <2630880){
                display=parseInt(diffTime/604800).toString() + 'weeks ago';
                isNew=true;
            }
            else if(diffTime>2630880 && diffTime<5261760){
                display='1 month ago';
                isNew=false;
            }
            else if(diffTime>5261760 && diffTime <31570560){
                display=parseInt(diffTime/2630880).toString()+' months ago';
                isNew=false;
            }
            else if(diffTime>31570560 && diffTime<63141120){
                display='1 year ago';
                isNew=false;
            }
            else{
                display=parseInt(diffTime/31570560).toString()+' years ago';
                isNew=false;
            }
            return display;

        }
        // $(document).on("click", '.editButton', function(event) {
            
        //  });
        $('#jobsalary').on('change', function() {
        // alert( this.value );specificSal
            if(this.value==2){
                $("#specificSal").show();
            }
            else{
                $("#specificSal").hide();
            }
            
        });
        $('#editsalary').on('change', function() {
        // alert( this.value );specificSal
            if(this.value==2){
                $("#especificSal").show();
            }
            else{
                $("#especificSal").hide();
            }
            
        });
        $(document).on("click", '.editButton', function(event) { 
            // clearForm();
            $('#editjobform').trigger("reset");
            $(".EditJobForm").show();
            $(".AddJobForm").hide();     
            $(".addJobTitle").hide();
            $(".editJobTitle").show();
            $(".addButton").hide();
            $(".editButton").show();
            var index = $(this).index(this);
            var id=$(this).attr('data-id');
            var skills="";
            var data=$(this).serialize()+"id="+id+ "&find";
            $.ajax({
                type:   "POST",
                url:    "action.php",
                data:   data,
                dataType : "json",
                success: function(data){
                    $("#jobid").val(id);
                    $("#edittitle").val(data.title);
                    $("#editdescription").val(data.description);
                    skills=data.skill.split(",");
                   var tagInputEle=$('#editskills');
                   tagInputEle.tagsinput('removeAll');
                    $.each(skills,function(i){
                        tagInputEle.tagsinput('add', skills[i]);
                    });
                    $("#editstatus").val(data.status).change();
                    $("#editlocation").val(data.location).change();
                    // $("#editsalary").val(2).change();
                    if(data.salary==1||data.salary==0){
                        $("#editsalary").val(data.salary).change()
                        $("#especificSal").hide();
                    }
                    else {
                        $("#editsalary").val(2).change();
                        $("#especificSal").show();
                        $("#especificSal").val(data.salary);
                    }
                    if(data.isworldwide==1){
                        $("input#editworldwide").prop( "checked", true );
                    }
                    else{
                        $("input#editworldwide").prop( "checked", false );
                    }                    

                }
            })
        });
        
         $(document).on("click", '.applyBtn', function(event) { 
            // var hasUser=getUserID();
            console.log(hasUser);

            if(hasUser==false){
                window.location.replace("./../login");
            }
            else {
                console.log("open apply modal");
              $("#modalApplyJob").modal();
            }
        });
          function getUserData(){

    
            var data=$(this).serialize()+ "&getUserType";
            $.ajax({
                type: "POST",
                data: data,
                url: "action.php",
                dataType: "json",
                success: function(data){
                    console.log(data);
                    if(data==null){
                        $('.applyBtn').show();
                        $('.editButton').hide();
                        $('.actionBar').hide();
                        hasUser=false;
                        fetchAllData();
                    }
                    else{
                        hasUser=true;
                        if(data.type==1){
                            console.log('unhide action button')
                            $('.applyBtn').hide();
                            $('.editButton').show();
                            $('.actionBar').show();
                            fetchAllDataWithUser()

                        }
                        else{
                            $('.applyBtn').show();
                            $('.editButton').hide();
                            $('.actionBar').hide();
                        
                        }
                    }

                }
            });
    }
   
    function country(code,isWorldWide){
        var name="";
        if(isWorldWide==1){
            name= code;
            // $("#jobDetails").append('<li>'+code+'</li>')
        }
        else{
            
        var data=$(this).serialize()+ "&country";
            $.ajax({
                type: "POST",
                data: data,
                url: "action.php",
                dataType: "json",
                async: false,
                success: function(data){
                    $.each(data, function(i) {
                        // console.log(data[i].Code);
                        // displayList="<option value='"+data[i].Code+"'>"+data[i].Name+"</option>"
                        //  $("#addlocation").append($('<option>', {value:'data[i].Code', text:'data[i].Name'}));
                        // $( '#addlocation' ).append( '<option value="1">Testing</option>');
                        if(data[i].Code==code){
                            console.log(data[i].Name);
                            // countryName=data[i].Name.toString();
                            name= data[i].Name;
                            // $("#jobDetails").append('<li>'+data[i].Name.toUpperCase()+'</li>')
                         }
                        
                    });
                }
            });
        }
        return name;
    }
    });

  
</script>