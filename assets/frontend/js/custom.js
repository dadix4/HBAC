$("document").ready(function () {
    $(".cp").keyup(function () {
        if ($(this).val().length === 5){
           $.ajax({
                type:'get',
                url : Routing.generate('getVilles', {cp: $(this).val()}),
                beforeSend: function () {
                    $(".ville option").remove();
                },
               success: function (data) {
                   //on fait une boucle des éléments du data et on ajoute les valeurs dans le select
                   $.each(data.ville, function (index,value) {
                       $(".ville").append($('<option>',{ value: value , text: value}))
                   });
                   $(".pays").val('France');//au champ du formulaire avec la class pays, on donne la valeur 'france'
                   console.log('ville OK')
               }
           });
        } else {
            $(".ville").val(''); //on affiche rien si code postal non remplit
            $(".pays").val('');
        }
    });
});