<script language="javascript">
        function check_pass(){
                if(document.user.firstname.value.length>1){
                        if(document.user.password.value==document.user.password2.value){
                                return true;
                        }
                        else{
                                alert("Mismatch password confirmation!");
                                document.user.password.value="";
                                document.user.password2.value="";
                                document.user.password.focus();
                                return false;
                        }
                }else{
                        alert("Firstname missing!");
                        document.user.firstname.focus();
                        return false;
                }
        }
</script>