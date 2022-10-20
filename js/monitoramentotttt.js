$.ajax({
    url: "./src/ramais.php",  
    type: "POST",
    dataType: 'json',
    success: function(data){                
        
        if(data){

            console.log(data);

        }
        
    },
    error: function(){
        console.log("Errouu!")
    }
});