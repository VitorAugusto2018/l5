
$.ajax({
    url: "./src/ramais.php",   
    type: "POST",
    dataType: 'json',
    success: function(data){                

        for(let i in data){

            //console.log(data[i].status)

            $('#cartoes').append(`   <div class="card-body cartao">
                                        <h5 class="card-title">${data[i].operador} - (${data[i].nome})</h5>                                                                            
                                        <span class="${data[i].status} icone-posicao"></span>
                                    </div>`)
        }
        
    },
    error: function(){
        console.log("Errouu!")
    }
});
              
