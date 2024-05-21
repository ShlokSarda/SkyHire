const firebaseConfig = {
    apiKey: "AIzaSyDSBFsBno_z_5onl9au6hlj7bdFRLetLFo",
    authDomain: "shining-landing-406713.firebaseapp.com",
    projectId: "shining-landing-406713",
    storageBucket: "shining-landing-406713.appspot.com",
    messagingSenderId: "80754798529",
    appId: "1:80754798529:web:564f94fedfc4f73ba60940",
    measurementId: "G-26JT5NM31E"
};
firebase.initializeApp(firebaseConfig);
render();
function render(){
    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
    recaptchaVerifier.render();
}

function phoneAuth() {
    var number = "+91" + document.getElementById('number-email').value;
    firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function (confirmationResult) {
        window.confirmationResult = confirmationResult;
        coderesult = confirmationResult;
        document.getElementById('sender').style.display='none';
        document.getElementById('main').innerHTML="Enter the 6-digit code sent to you at "+number+".";
        document.getElementById('verifier').style.display='block';
        document.getElementById('resend').style.display='block';
        console.log('OTP Sent');
        resendOTP();
    }).catch(function (error) {
        // error in sending OTP
        alert(error.message);
    });
}
// function for OTP verify
function codeverify() {
    var number=document.getElementById('number-email').value;
    if(isValidPhoneNumber("+91"+number)){
        var code = document.getElementById('verificationcode').value;
        coderesult.confirm(code).then(function () {
            console.log('OTP Verified');
           // document.getElementsByClassName('n-conf')[0].style.display='none';
            window.location.href="Customer Dashboard/customer_dashboard.php";
        }).catch(function () {
            console.log('OTP Not correct');
            document.getElementsByClassName('n-conf')[0].style.display='block';
        })
    }
}

// function for resend button
function enableResendButton(){
    document.getElementById("resend").disabled = false;
    document.getElementById("resend").style.cursor='default';
    clearInterval(intervalId);
}
function resendOTP(){
    document.getElementById("resend").disabled=true;
    document.getElementById("resend").style.cursor='no-drop';
    setTimeout(enableResendButton, 11010);
    startTimer(10);
}
function startTimer(duration){
    var timerDisplay=document.getElementById("resend");
    var timer=duration;
    intervalId = setInterval(function (){
        timer--;
        timerDisplay.innerHTML="Resend Code (0:0"+timer+")";
        if(timer<0){
            clearInterval(intervalId);
            timerDisplay.innerHTML="Resend Code";
        }
    },1000);
}
function changeNumber(){
    document.getElementById('sender').style.display='block';
    document.getElementById('verifier').style.display='none';
    render();
    function render(){
        window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
        recaptchaVerifier.render();
    }
}
document.getElementById('change-number').addEventListener("click",changeNumber);

//function for phone number check
function isValidPhoneNumber(phoneNumber){
    const phoneRegex=/^\+91[0-9]{10}$/;
    return phoneRegex.test(phoneNumber);
}

function authenticate(){
    var Number=document.getElementById('number-email').value;
    if(isValidPhoneNumber("+91"+Number)){
        const xhr = new XMLHttpRequest();
            xhr.open("GET", "../assets/database/Customer/Customer_Signin.php?number=" + Number, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    const response = xhr.responseText;
                    console.log(response);
                    if (response === "Number available") {
                        document.getElementById('number-usage').style.display='block';
                    }
                    else {
                        document.getElementById('number-usage').style.display='none';
                        phoneAuth();
                    }
                }
            };
            xhr.send();
    }
}