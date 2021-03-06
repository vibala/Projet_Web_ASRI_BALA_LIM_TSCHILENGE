<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $cakeDescription ?>:
            <?php echo $this->fetch('title'); ?>
        </title>
        <?php
        echo $this->Html->meta('icon');
        //echo $this->Html->css('cake.generic'); // feuille de style du framework cakephp
        // echo $this->Html->script('datatable');
        //  echo $this->Html->css('datatable');
        //  echo $this->Html->css('myTable');
        
        echo $this->Html->css('jquery-ui');
        echo $this->Html->css('style');
        echo $this->Html->css('webarena');
        
        echo $this->Html->script('jquery-1.11.3');        
        echo $this->Html->script('jquery.js'); // Inclut la librairie Jquery
        echo $this->Html->script('jquery-ui.js'); // Inclut la librairie Jquery                  
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
    </head>
    <body>

        <nav>     
            <ul>
               <li class="home"><?php echo $this->Html->link('Home', array('controller'=> 'arenas', 'action'=>'accueil')); ?></li>
            <li class="tutorials"><?php echo $this->Html->link('Connexion', array('controller'=> 'users', 'action'=>'login')); ?></li>
            <li class="about"><?php echo $this->Html->link('Combattant', array('controller'=> 'arenas', 'action'=>'fighter')); ?></li>
            <li class="about"><?php echo $this->Html->link('Vision', array('controller'=> 'arenas', 'action'=>'sight')); ?></li>
            <li class="about"><?php echo $this->Html->link('Infos', array('controller'=> 'arenas', 'action'=>'news')); ?></li>
            <li class="about"><?php echo $this->Html->link('Hall of Fame', array('controller'=> 'arenas', 'action'=>'hall_of_fame')); ?></li>
            <li class="news"><?php echo $this->Html->link('Forum', array('controller'=> 'arenas', 'action'=>'forum')); ?></li>
            <li class="contact"><?php echo $this->Html->link('Contacts', array('controller'=> 'arenas', 'action'=>'contact')); ?></li>
            </ul>
        </nav>

        <div id="container">
            <!--<div id="header">
                    <h1><?php echo $this->Html->link($cakeDescription, 'http://cakephp.org'); ?></h1>
                    <h1> <?php echo $this->Html->link('Vision', array('controller' => 'Arenas', 'action' => 'sight')); ?> </h1>
                    <h1> <?php echo $this->Html->link('Accueil', '/'); ?> </h1>
            </div> -->
            <div id="content">

<?php echo $this->Session->flash(); ?>

                <?php echo $this->fetch('content'); ?>
            </div>
            <div id="footer">
<?= $this->html->link('Deconnexion', array('controller' => 'users', 'action' => 'logout')); ?>
                <?php
                echo $this->Html->link(
                        $this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')), 'http://www.cakephp.org/', array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
                );
                ?>
                <p>
                <?php
                echo $cakeVersion;
                echo "\nGr2-06-BG - BALA VIGNESH - ASRI ANAS - LIM VINCENT - TSCHILENGE DONATIEN";
                ?>
                </p>

            </div>
        </div>
<?php /* echo $this->element('sql_dump'); */ ?>
    </body>
</html>