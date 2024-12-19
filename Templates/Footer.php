<footer class="footer-xmas">
    <img src="../images/xmas_up.png" alt="Sprite" class="sprite-xmas">
    <div class="container">
        <div class="col-md-2" style="padding: 10px;">
            <center><img src="https://www.habbo.es/habbo-imaging/badge/b08134s86115s96114s80113t271111fd2ce747251db16d890f73b86a9cb03.gif" style="width: 40%"></center>
        </div>
        <div class="col-md-10">
            <h4><?php echo $lang[289]; ?></h4>
            <?php echo $lang[290]; ?>
        </div>
    </div>
</footer>

<div class="footer-copyright">
    <div class="container">
        &#169; Copyright 2024 <?php echo $nameweb; ?> <?php echo $lang[201]; ?> | <?php echo $lang[202]; ?>
        <a class="footer1" target="_blank" href="https://www.habbo.es/profile/-News.">-News.</a> & 
        <a class="footer1" target="_blank" href="https://www.habbo.es/profile/artemisaa509">artemisaa509</a>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<div style='visibility: hidden; display: none; position: absolute;'>
    <script id='_wauxzi'>
        var _wau = _wau || [];
        _wau.push(['small', '<?php echo $contador ?>', 'xzi']);
        (function() {
            var s = document.createElement('script');
            s.async = true;
            s.src = '//widgets.amung.us/small.js';
            document.getElementsByTagName('head')[0].appendChild(s);
        })();
    </script>
</div>

<!-- Bootstrap core JavaScript -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Merriweather+Sans" rel="stylesheet">
<script type="text/javascript" src="ajax.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.10/cookieconsent.min.js"></script>
<script src="<?php echo $url; ?>/styles/js/bootstrap.min.js"></script>
</body>
</html>


<style>
    /* Estilos footer Halloween */
    .footer-halloween {
        background-color: #303030; /* Fondo gris oscuro */
        box-shadow: 0 0px 60px 0px #000; /* Sombra negra */
        background-image: url('../images/ghost.png'), url('../images/ghost.png'); 
        background-size: 7%, 7%; 
        background-repeat: no-repeat, no-repeat; 
        background-position: left center, right center;
        position: relative;
        margin-top: 10%; /* Margen superior para separar el footer del contenido superior */
    }

    /* Estilos sprite Halloween */
    .sprite-halloween {
        width: 100px;
        position: absolute;
        left: 50%;
        top: -100px; /* Posiciona la imagen arriba del footer */
        transform: translateX(-50%); /* Centra la imagen horizontalmente */
        animation: float 4s ease-in-out infinite; /* Añade animación de flotación */
        filter: drop-shadow(0 0 20px rgba(138, 43, 226, 0.8)) 
        drop-shadow(0 0 40px rgba(138, 43, 226, 0.5)); /* Sombra morado-azul */
    }

    /* Estilos footer Navidad */
    .footer-xmas {
        background-color: rgba(150,0,0);
        box-shadow: 0 0px 60px 0px rgba(255,0,0,0.4); 
        background-image: url('../images/xmas_footer.png'), url('../images/xmas_footer.png');
        background-size: 6%, 6%; 
        background-repeat: no-repeat, no-repeat; 
        background-position: left center, right center;
        position: relative;
        margin-top: 10%;
    }

    /* Estilos footer Navidad */
    .sprite-xmas {
        width: 100px; /* Tamaño de la imagen del sprite */
        position: absolute;
        left: 50%;
        top: -100px; /* Posiciona la imagen arriba del footer */
        transform: translateX(-50%); /* Centra la imagen horizontalmente */
        animation: float 4s ease-in-out infinite; /* Añade animación de flotación */
        filter: drop-shadow(0 0 20px rgba(255, 0, 0, 0.8)) 
                drop-shadow(0 0 40px rgba(255, 0, 0, 0.5)); /* Sombra roja para un efecto navideño */
    }

    /* Estilos footer Otoño */
    .footer-fall {
        background-color: #8B4513; 
        box-shadow: 0 0px 60px 0px rgba(139, 69, 19, 0.4);
        background-image: url('../images/fall_footer.png'), url('../images/fall_footer.png');
        background-size: 6%, 6%;
        background-repeat: no-repeat, no-repeat;
        background-position: left center, right center;
        position: relative;
        margin-top: 10%;
    }

    /* Estilos sprite Otoño */
    .sprite-fall {
        width: 100px; /* Tamaño de la imagen del sprite */
        position: absolute;
        left: 50%;
        top: -100px; /* Posiciona la imagen arriba del footer */
        transform: translateX(-50%); /* Centra la imagen horizontalmente */
        animation: float 4s ease-in-out infinite; /* Añade animación de flotación */
        filter: drop-shadow(0 0 20px rgba(255, 165, 0, 0.8)) /* Sombra naranja otoñal */
                drop-shadow(0 0 40px rgba(255, 140, 0, 0.5)); /* Sombra de naranja cálido */
    }

    /* Estilos para el contenedor de copyright */
    .footer-copyright {
        padding: 10px; 
        background-color: white;
        color: black; 
        text-align: center;
    }

    .footer-copyright .footer1 {
        color: red; /* Color de los enlaces */
    }

    /* Animación flotante */
    @keyframes float {
        0% {
            transform: translateX(-50%) translateY(0); /* Sin movimiento en Y al inicio */
        }
        50% {
            transform: translateX(-50%) translateY(20px); /* Baja 20px */
        }
        100% {
            transform: translateX(-50%) translateY(0); /* Vuelve a la posición inicial */
        }
    }

</style>