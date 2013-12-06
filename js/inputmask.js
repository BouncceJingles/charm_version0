$.getScript("/js/jquery.maskedinput.js", function(){
  $(document).ready(function(){
    /*name*/        $.mask.definitions['n']='[a-zA-Z ().]';
    /*nric*/        $.mask.definitions['s']='[STFGstfg]';
    /*specialchar*/ $.mask.definitions['c']='[`~!@#$%^&*()-_=+[{]}\|;:\'",<.>/?]';
    /*allchar*/     $.mask.definitions['k']='[a-zA-Z0-9`~!@#$%^&*()-_=+[{]}\|;:\'",<.>/?]';

    $("#txtNric").mask("?s9999999a",{placeholder:" "});
    $("#txtNric").blur(function(){this.value=this.value.toUpperCase();});
    //$("#txtPW").mask("?cccccccccccccccccccccccccccccc",{placeholder:" "});
    //$("#password1").mask("?cccccccccccccccccccccccccccccc",{placeholder:" "});
    //$("#password2").mask("?cccccccccccccccccccccccccccccc",{placeholder:" "});
    $("#fullName").mask("?nnnnnnnnnnnnnnnnnnnnnnnnnnnnnn",{placeholder:" "});
    $("#fullName").blur(function(){
      this.value=this.value.toLowerCase().replace(/\b[a-z]/g,
        function(letter){return letter.toUpperCase();});
    });
    //$("#dob").mask("?99/99/9999",{placeholder:" "});
    //$("#checkInDate").mask("?99/99/9999",{placeholder:" "});
    $("#emergencyContactNumber").mask("99999999",{placeholder:" "});
  });
});