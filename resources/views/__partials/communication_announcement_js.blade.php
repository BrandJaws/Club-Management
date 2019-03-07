
<script>
    var baseUrl = "{{url()}}";
    var vueAnnouncements = new Vue({
    el:'#vue-announcements-container',
    data:{
       msgBody:""
    },
    methods:{
       submitAnnouncement: function(){
           showProgressRing();
           
            var request = $.ajax({

              url: baseUrl+'/communication/mobile-announcement',
              method: "POST",
              data: { 
                  msgBody:this.msgBody,
                  dataType: "html"
              },
              success:function(msg){
                    console.log(msg);
                       
                       if(msg == "Announcement made Successfuly"){
                           this.msgBody = "";
                       }
                      hideProgressRing();
                    }.bind(this),

              error: function(jqXHR, textStatus ) {
                   console.log( jqXHR );
                   console.log( "Request failed: " + textStatus );
                   hideProgressRing();
              }
            }); 

       }
    }
});

function showProgressRing(){
     $(".se-pre-con").fadeIn("fast");
}

function hideProgressRing(){
    $(".se-pre-con").fadeOut("fast");
}
</script>

