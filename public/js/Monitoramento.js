const Monitoramento = {

    list : function(){

        $.ajax({
            url: "index.php?route=list",   
            type: "GET",
            dataType: 'json',
            success: function(data){    
                
                $('#cartoes').html('');
                
                for(let i in data){
        
                    console.log(data)
        
                    $('#cartoes').append(`  <div style="margin-left: 20px; margin-bottom: 20px;">
                                                <div class="card" style="width: 18rem; background-color: #f3f9ff;" >
                                                    <div style="align-self: center;" class="card-header" >
                                                        <img src="./img/${data[i].nome}.png" class="rounded-circle" alt="Cinque Terre" style="align" width="100" height="100"> 
                                                        
                                                    </div>
                                                    <div class="card-body" style="align-self: center;">
                                                        <blockquote class="blockquote mb-0">
                                                            <p>${data[i].nome} - (${data[i].ramal})</p>                                                     
                                                            <footer style="aligtn-self: center">
                                                                <button type="button" class="${data[i].status} btn btn-lg btn-primary" disabled>${data[i].status}</button>
                                                            </footer>
                                                        </blockquote>
                                                    </div>
                                                </div>
                                            </div>`)
                }
                
            },
            complete: function(){

                setTimeout(function(){
                    Monitoramento.update();
                }, 3000);

            },
            error: function(){
                console.log("Errouu!")
            }
        });

    },

    update : function(){
        $.ajax({
            url: "index.php?route=updateDb",   
            type: "GET",
            dataType: 'json',
            complete: function(){
                Monitoramento.list();
            }
        })

    }

}