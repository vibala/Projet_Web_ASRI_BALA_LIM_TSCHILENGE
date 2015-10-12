<!DOCTYPE html>
<html>
    <head>
         <meta charset="utf-8" />
         <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
         <meta http-equiv="Content-Language" content="fr" />
         <title>Test PHP</title>
         <?php $this->assign('title', 'SIGHT');?>
    <head>
        
    <body>        
        <h1> Formulaires: </h1>
        <article> 
            <h2>Move Form</h2>
            <?php
                echo $this->Form->create('Fightermove', array('type' => 'get'));              
                echo $this->Form->input('direction_move',array('options' => array('north'=>'north','east'=>'east','south'=>'south','west'=>'west'), 'default' => 'east'));
                echo $this->Form->end('Move');
            ?>
        </article>   
        
        
        <article>
            <!--<h2> Enter the name of your fighter to track all its ennemies</h2>-->
            <form>
                <fieldset>
                    <legend> Enter the name of your fighter to track all its ennemies </legend>
                    <p> <label for="Fighter_Name"> Fighter Name: </label> </p>
                    <p> <input type="text" id="Fighter_Name" name="Fighter_Name" />  </p>                  
                    <input type="hidden" value="" id="hidden_name" />
                    <p> <input type="submit" id="enter" value="Enter"/> </p>
                </fiedset>
            </form>
            
        </article>
        
        <article id="track_ennemy">
            <form>
                <fieldset>
                    <legend> Choose the ennemy to attack </legend>
                    <p> <label for="List_ennemies"> Ennemy name :  </label> </p>
                    <p> <select name="ennemies" id="ennemies"> </select> </p>
                    <input type="hidden" value="" id="hidden_times"/>
                    <p> <input type="submit" id="choose" value="Choose" /> </p>
                </fiedlset>                
            </form>    
        </article>
        
        <article id="list_options">
            <h2> Choose your different options : </h2>
            <p id="info_options"> </p>         
            <p>
                 <label for="nb_view"> Number of views to increment:</label>
                 <input type="text" id="nb_views" readonly style="border:0; color:#f6931f; font-weight:bold;">
                 <div id="slider_views"></div>      
            </p>
           
            
            <p>
                 <label for="nb_force"> Number of force to increment:</label>
                 <input type="text" id="nb_forces" readonly style="border:0; color:#f6931f; font-weight:bold;">
                 <div id="slider_forces"></div> 
            </p> 
            
            
            <p>
                 <label for="nb_life_points"> Number of views to increment:</label>
                 <input type="text" id="nb_life_points" readonly style="border:0; color:#f6931f; font-weight:bold;">
                 <div id="slider_life_points"></div> 
            </p> 
            <p> <input type="submit" id="validate" value="Validate" /> </p>
            <p id="rappel"> </p>
        </article>
        
        
        <article>
            <h2> Move to the Next Level  </h2>
            <?php                
                echo $this->Form->create('MovetotheNextLevel', array('type' => 'get'));                              
                echo $this->Form->input('next_level',array('options' => array('one'=>'one','two'=>'two','third'=>'third','fourth'=>'fourth','five'=>'five','six'=>'six'), 'default' => 'zero'));
                echo $this->Form->end('Change the level');
            ?>
        </article>
        
        <article>
            <h2> Design your character </h2>
            <?php
                 echo $this->Form->create('MovetotheNextLevel', array('type' => 'get'));                                               
                 echo $this->Form->inputs(array('legend' => 'Design your character','character_name' => array('type'=>'text'), 'player_id' => array('type'=>'text')));                 
                 echo $this->Form->end('Create');
            ?>
        </article>
        
        <article>
            <h2> Create your avatar </h2>
            <?php
                echo $this->Form->create('Createyouravatar',array('type' => 'file'));            
                echo $this->Form->inputs(array('legend' => 'Make your own avatar', 'avatar_name' => array('type'=>'text'),'avatar_identifier' => array('type'=>'text'),'avatar_image' => array('type' => 'file')));                
                echo $this->Form->end('Create');
            ?>            
        </article>
        
        <script>
            
         $(function(){   
                
                // on cache la partie choix d'ennemi et on l'affichera qd la fonction trouve des adversaires aux alentours
                $("#track_ennemy").hide();    
                // cache la partie option et on affichera suivant l'issue du combat entre le combattant et l'adversaire
                $("#list_options").hide();
                
                // écrire la phrase de rappel des règles sur les options
                $("#rappel").html("Rappel : 1 option => +1 vue ou +1 force ou +3 point de vie").css('color','green');
                
                $('#enter').on('click',function(){                  
                    $('#hidden_name').val($('#Fighter_Name').val());
                    $.get(                         
                        // on se sert d'un helperHTML cakephp                                                     
                        '<?php 
                                // HtmlHelper::url(mixed $url = NULL, boolean $full = false) cd : cakephp doc                           
                                // remarque : action ; on retrouve svt cet attribut à l'intérieur de la balise form et 
                                // indique la page php qui se charge de récupérer les données et de les traiter                                                     
                                echo Router::url(array('controller' => 'arenas', 'action' => 'ajaxProcessing'));                                                                                     

                        ?>',                                    
                                    
                        {fighter_name: $('#Fighter_Name').val()},                         
                        
                        function(json) {                                                        
                            $.each(json,function(i,item){
                                //alert(i +'=>' + item);
                                $("#track_ennemy").show();
                                $('#ennemies').append("<option>"+ item+ "</option>");  
                            });                                            

                        },                              
                           'json'
                       );
                    return false;
                }); 
               
            $('#choose').on('click', function(){                                        
                    $.get(
                      '<?php
                             echo Router::url(array('controller' => 'arenas', 'action' => 'ajaxProcessingVFLP'));                                                                                     
                        ?>',        
                            
                        {fighter_name: $('#hidden_name').val(),
                         ennemy_name: $('#ennemies').val()},
                        
                        function(json){  
                            $("#hidden_times").val(json['nb_times']);
                            if(json['nb_times'] > 0){
                                $("#list_options").show();
                                if(json['nb_times'] === 1){
                                    $("#info_options").html("L'attaque est réussie et en plus vous venez de gagner 4 (ou plus) points d'expériences. <br/>Vous devez maintenant choisir " + json['nb_times'] + " option").css("color","red");
                                }else{
                                    $("#info_options").html("L'attaque est réussie et en plus vous venez de gagner 4 (ou plus) points d'expériences. <br/>Vous devez maintenant choisir " + json['nb_times'] + " options").css("color","red");   
                                }  
                                
                                // slider pour représenter les options pour les vues
                                $( "#slider_views" ).slider({
                                    value:1,
                                    min: 0,
                                    max: json['nb_times'],
                                    step: 1,
                                    slide: function( event, ui ) {
                                        $( "#nb_views" ).val(ui.value );
                                    }
                                });

                                // affiche en tps réel les valeurs du slider
                                $( "#nb_views" ).val( "+" + $( "#slider_views" ).slider( "value" ) );
                                
                                // slider pour représenter les options pour les forces
                                $( "#slider_forces" ).slider({
                                    value:1,
                                    min: 0,
                                    max: json['nb_times'],
                                    step: 1,
                                    slide: function( event, ui ) {
                                       $( "#nb_forces" ).val(ui.value );
                                    }
                                });

                                // affiche en tps réel les valeurs du slider
                                $( "#nb_forces" ).val( "+" + $( "#slider_forces" ).slider( "value" ) );

                                // slider pour représenter les options pour les vies
                                $( "#slider_life_points" ).slider({
                                    value:3,
                                    min: 0,
                                    max: (3*json['nb_times']),
                                    step: 3,
                                    slide: function( event, ui ) {
                                        $( "#nb_life_points" ).val(ui.value );
                                    }
                                });

                                // affiche en tps réel les valeurs du slider
                                $( "#nb_life_points" ).val( "+" + $( "#slider_life_points" ).slider( "value" ) );                                
                            }else{
                                 location.reload(true);
                            }
                        },                   
                     'json'
                    );
                return false;                   
            });   
            
           $("#validate").on('click',function(){
                var slider_value_lp = ($("#slider_life_points" ).slider( "value" ) / 3);
                var slider_value_views = $( "#slider_views" ).slider( "value" );
                var slider_value_forces = $( "#slider_forces" ).slider( "value" );
                if((slider_value_lp + slider_value_views + slider_value_forces) > $("#hidden_times").val()){                    
                    alert("Vous avez choisi plus d'options");
                }else if((slider_value_lp + slider_value_views + slider_value_forces) < $("#hidden_times").val()){                    
                    alert('Il faut choisir ' + $("#hidden_times").val() + " option(s)");
                }else{
                    $.get(
                        '<?php
                             echo Router::url(array('controller' => 'arenas', 'action' => 'ajaxFinishingVFLP'));                                                                                     
                        ?>',        
                            
                        {name: $('#hidden_name').val(),
                         lp_choosen: slider_value_lp,
                         views_choosen: slider_value_views,
                         forces_choosen: slider_value_forces
                        },
                        
                        function(json){
                            var message = "Votre combattant " + $('#hidden_name').val() + " a été mis à jour. \n\
                            Il possède désormais :\n\
                            - Skill strength : " + json['skill_strength'] +"\n\
                            - Current health : " + json['current_health'] + "\n\
                            - Skill sight : " + json['skill_sight'] +" ";
                            alert(message);
                            location.reload(true);
                        },
                    
                        'json'
                    );
                    
                }    
               return false;
           });
        });
        
        
        
        </script>
    </body>

</html>


