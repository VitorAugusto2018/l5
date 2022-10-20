
$.ajax({
    url: "./src/ramais.php",   
    type: "POST",
    dataType: 'json',
    success: function(data){                

        for(let i in data){

            //console.log(data[i].status)

            $('#cartoes').append(`      
                                    <div class="card" style="width: 18rem;">
                                        <div class="card-header ${data[i].status}" >
                                            ${data[i].operador} - (${data[i].nome})                                                                                                                                
                                        </div>
                                        <div class="card-body">
                                            <blockquote class="blockquote mb-0">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                                            <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer>
                                            </blockquote>
                                        </div>
                                    </div>`)
        }
        
    },
    error: function(){
        console.log("Errouu!")
    }
});
              
