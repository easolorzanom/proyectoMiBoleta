<?php
    function buscarImagen($indice){
        switch ($indice) {
            case 1:
                echo "<div class='text-center'><img src='./img/evento_1.jpg' width='70%' /></div>";
                break;
            case 2:
                echo "<div class='text-center'><img src='./img/evento_2.png' width='80%' /></div>";
                break;
            case 3:
                echo "<div class='text-center'><img src='./img/evento_3.png' width='80%' /></div>";
                break;
            case 4:
                echo "<div class='text-center'><img src='./img/evento_4.png' width='90%' /></div>";
                break;
            case 5:
                echo "<div class='text-center'><img src='./img/evento_5.png' width='90%' /></div>";
                break;
            default:
            echo "<div class='text-center'><img src='https://icons.iconarchive.com/icons/custom-icon-design/mono-general-1/256/faq-icon.png' width='70%' /></div>";
                break;
        }
    }
?>