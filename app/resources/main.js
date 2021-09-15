new Vue({ 
    el: '#app',
    data:{
        savings:false,
        withdrawal:false,
        change_pin:false,
        acc_number:"",
        pin:"",
        item:"",
        login:true,
        buttonshow:false,
        alert:false,
        alert_msg:'',
        balence:0,
        new_pin:'',
        re_pin:'',
        base_url:window.location.origin,
        account_savings:'',
        withdraw_amount:'',
        reciept_msg:'',
        reciept:false,
        name:'',
    }, 
    created(){

    },
    methods:{
        logout: function (){ 
            var self = this;
            jQuery.ajax({
                url: this.base_url+'/accounts/logout',
                type: 'GET',
                success: function (result) {
                    if(result == 'true'){
                        self.buttonshow = false;
                        self.login=true;                    
                    }
                },
                failure: function (errMsg) {
                }
            })
        },

        downloadStatement(){
            var self = this;
            jQuery.ajax({
                url: this.base_url+'/transaction/download?name=statement',
                type: 'GET',
                success: function (result) {
                    window.location=window.location.origin+"/transaction/download?name=statement";
                },
                failure: function (errMsg) {
                }
            })
        },

        saving(){
            var self = this;
            jQuery.ajax({
                url: this.base_url+'/transaction/getbalence',
                type: 'GET',
                success: function (result) {
                    result=JSON.parse(result);
                    self.account_savings=result['balance'];
                    self.name=result['name'];
                },
                failure: function (errMsg) {
                }
            })
        },
        auhthenticate: function (item){           
            var self = this;
            jQuery.ajax({
                    data: {'acc-number' :this.acc_number, 'pin':this.pin },
                    url: this.base_url+'/accounts/submit/login',
                    type: 'POST',
                    success: function (result) {
                        if(result == "true"){                        
                            self.buttonshow = true;
                            self.withdrawal=true;
                            self.login=false;                     
                        }else{
                            self.alert_msg=result;
                            self.alert = true;
                        }
                    },
                    failure: function (errMsg) {
                    }
                })
            item. preventDefault();              
        },
        changePin: function (item){
            item. preventDefault();
            if((this.new_pin!==this.re_pin) || (this.new_pin.length < 4 || this.new_pin.length > 4 )){
                this.alert=true;
                this.alert_msg="Please follow correct format!";
                return;
            }
            var self = this;
            jQuery.ajax({
                data: {'old-password' :this.old_pin, 'new-password':this.new_pin, 'new-repassword':this.re_pin },
                url: this.base_url+'/accounts/submit/changepin',
                type: 'POST',
                success: function (result) {
                    if(result == "true"){
                        self.alert=true;
                        self.alert_msg="Pin successfully changed"; 
                    }
                    else{
                        self.alert=true;
                        self.alert_msg="Pin not changed try again later";
                    }
                },
                failure: function (errMsg) {
                }
            })
        },
        cashWithdraw: function (item) {
            item.preventDefault();
            var self = this;
            jQuery.ajax({
                data: { 'amount': self.withdraw_amount },
                url: this.base_url+"/transaction/submit/dashboard",
                type: 'POST',
                success: function (result) {
                result = result.substring(0,result.indexOf("}")+1);
                result.trim();
                result = JSON.parse(result);
                if(result['status'] === true){
                    window.location = window.location.origin + "/transaction/download?name=receipt";
                }
                    self.reciept=true;
                    self.reciept_msg=result['message'];
                },
                failure: function (errMsg) {
                }
            })
        }

    }, 
    template:`
    <div class="maincontainer">
        <center>
            <h1> ATM SIMULATION</h1>
        </center>
        <div class="login" v-show="login">
            <form method="POST" action="base_url/submit/login">
                <label for="AccountNumber"><b>Account Number</b></label>
                <input type="text" name="acc-number" maxlength="10" v-model="acc_number" placeholder="Enter Account Number"
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '')" name="email" required>
                <label for="pin"><b>Pin</b></label>
                <input type="password" v-model="pin"  maxlength="4" name="pin" placeholder="Enter password"
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '')" required>
                <button class="button" type="submit" value="submit" @click="auhthenticate">Submit</button>
                <pre v-show="alert">{{alert_msg}}</pre>
            </form>
        </div>
        <div v-show="buttonshow" class="buttonshow">
            <button class="button"
                @click="saving(), alert=false, savings = !savings, withdrawal = false, change_pin = false">Savings</button>
            <button class="button"
                @click="savings = false,alert=false, withdrawal = !withdrawal ,change_pin = false, login=false ">withdrawal</button>
            <button class="button"
                @click="change_pin = !change_pin,alert=false, savings = false, withdrawal = false,login=false">Change
                Pin</button>
            <button class="button"
                @click="downloadStatement(), change_pin = false,alert=false, savings = false, withdrawal = false,login=false">Download
                Statement</button>
            <button class="button logout"
                @click="logout() ,change_pin = false, alert=false, savings = false, withdrawal = false,login=false">Logout</button>
        </div>
        <div v-show="savings" class="display">
            <h2>Account Details </h2>
            <br>
            <p> Account Holder Name: {{name}}</p>
            <p> Account Number: {{acc_number}}</p>
            <p> Account Balance: $ {{account_savings}}</p>
        </div>
        <div v-show="change_pin" class="changepin">
            <h2> Change your pin here</h2>
            <form method="POST" action="base_url/accounts/submit/changepin">
                <table class="pinblock">
                    <tr>
                        <td>
                            New Pin
                        </td>
                        <td>
                            <input type="password" v-model="new_pin" name="new_pin" maxlength="4" placeholder="Enter New pin"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '')" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Re-enter Pin
                        </td>
                        <td>
                            <input type="password" v-model="re_pin" name="re_pin" maxlength="4" placeholder="Re-Enter  pin"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '')" required>
                        </td>
                    </tr>
                </table>
                <button class="pinSubmit button" type="submit" value="submit" @click="changePin">Submit</button>
                <pre v-show="alert">{{alert_msg}}</pre>
            </form>
        </div>
        <div v-show="withdrawal">
            <center>
                <pre v-show="reciept">{{reciept_msg}}</pre>
            </center>
            <div class="login">
                <form method="POST" class="login" action="base_url/transaction/submit/dashboard">
                    <label for="Withdraw Amount"><b>Withdraw Amount</b></label>
                    <input type="text" name="amount" v-model="withdraw_amount" placeholder="Enter withdraw Amount"
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '')" required>
                    <button class="button" type="submit" value="submit" @click="cashWithdraw">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
    `,   
});

