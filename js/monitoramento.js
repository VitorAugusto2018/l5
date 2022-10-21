
$.ajax({
    url: "./src/ramais.php",   
    type: "POST",
    dataType: 'json',
    success: function(data){                
        
        for(let i in data){

            //console.log(data[i].status)

            $('#cartoes').append(`  <div style="margin-left: 20px; margin-bottom: 20px;">
                                        <div class="card" style="width: 18rem; background-color: #f3f9ff;" >
                                            <div style="align-self: center;" class="card-header" >
                                                <img src="./src/${data[i].operador}.png" class="rounded-circle" alt="Cinque Terre" style="align" width="100" height="100"> 
                                                
                                            </div>
                                            <div class="card-body" style="align-self: center;">
                                                <blockquote class="blockquote mb-0">
                                                    <p>${data[i].operador} - (${data[i].nome})</p>                                                     
                                                    <footer style="aligtn-self: center">
                                                        <button type="button" class="${data[i].status} btn btn-lg btn-primary" disabled>${data[i].status}</button>
                                                    </footer>
                                                </blockquote>
                                            </div>
                                        </div>
                                    </div>`)
        }
        
    },
    error: function(){
        console.log("Errouu!")
    }
});
              
