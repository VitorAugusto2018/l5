
$.ajax({
    url: "./src/ramais.php",   
    type: "POST",
    dataType: 'json',
    success: function(data){                

        for(let i in data){

            //console.log(data[i].status)

            $('#cartoes').append(`<div class="cartao">
                                <div>${data[i].nome}</div>
                                <span class="${data[i].status} icone-posicao"></span>
                            </div>`)
        }
        
    },
    error: function(){
        console.log("Errouu!")
    }
});
              
