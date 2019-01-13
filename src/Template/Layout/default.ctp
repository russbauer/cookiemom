<?php
$cakeDescription = 'TCM: The Cookie Manager';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <!-- JQuery (load first) -->  
    <script
			  src="https://code.jquery.com/jquery-3.3.1.min.js"
			  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			  crossorigin="anonymous"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"/>  
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>   

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- Vue.js -->
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <?= $this->Html->css("default");?>
</head>
<body>
    <?= $this->Flash->render() ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <ul class="nav">
        <li class="nav-item">
            <?= $this->Html->link(__('Users'), ['controller'=>'users', 'action' => 'index'], ['class' => 'nav-link']) ?>
        </li>
        <li class="nav-item">
            <?= $this->Html->link(__('Orders'), ['controller'=>'orders', 'action' => 'index'], ['class' => 'nav-link']) ?>
        </li>
        <li class="nav-item">
            <?= $this->Html->link(__('Cookies'), ['controller'=>'cookies', 'action' => 'index'], ['class' => 'nav-link']) ?>
        </li>
        <li class="nav-item">
            <?= $this->Html->link(__('Log Off'), ['controller'=>'users', 'action' => 'logout'], ['class' => 'nav-link']) ?>
        </li>
    </ul>
    </nav>
    <div class="content">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
