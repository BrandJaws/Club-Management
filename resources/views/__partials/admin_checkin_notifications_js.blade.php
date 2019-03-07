
<script>
    var iconClasses = {entry:'fa-bell-o',
                       checkin:'fa-bolt',
                       exit:'fa-bullhorn'};
    var vueFeeds = new Vue({
    el:'#vue-checkin-feeds-container',
    data:{
       checkinsList:[]
    },
    methods:{
    
    }
});
</script>

<script>
var socket = io("localhost:3000");

socket.on('checkins-channel:MemberCheckin',function(data){
   
    try{
        data = JSON.parse(data);
         if(data.checkinType == "ENTRY"){
            
            data.iconClass = iconClasses.entry;
        }else if(data.checkinType == "CHECKIN"){
            data.iconClass = iconClasses.checkin;
        }else if(data.checkinType == "EXIT"){
            data.iconClass = iconClasses.exit;
        }

        vueFeeds.checkinsList.push(data);
         
    }catch(e){
        console.log(e);
    }
    
   
});
        
        
</script>