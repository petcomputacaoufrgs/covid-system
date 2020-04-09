<?php
    $html ='';
    if(isset($_POST['adicionar'])){
        //fazer o cadastro
        echo $_POST['sel_tipoAmostra'];
        echo $_POST['numQntTubos'];
        echo $_POST['numPosicao'];
        echo $_POST['sel_local'];
        
        $arr = array($_POST['sel_tipoAmostra'],$_POST['numQntTubos'],$_POST['numPosicao'],$_POST['sel_local']);
        
        print_r($arr);
        
        //colocar na url o id do tipolocal
        
        $html = '<div class="form-row">
                    <div class="col-md-4">
                        <label for="tipoAmostra">Tipo de amostra</label>
                        <div class="form-group">
                            <select class="custom-select" required>
                                <option value="">Selecione o tipo da amostra</option>
                                <option value="1">congelada</option>
                                <option value="2">normal</option>
                            </select>
                            <div class="invalid-feedback">Example invalid custom select feedback</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="validationServer02">Quantidade de tubos</label>
                        <input type="number" class="form-control is-valid" id="validationServer02" placeholder="" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div> 
                    <div class="col-md-2">
                        <label for="tipoLocalArmazenamento">Tipo do local de armazenamento</label>
                        <div class="form-group">
                            <select class="custom-select" required>
                                <option value="">Selecione o local</option>
                                <option value="1">gaveta</option>
                                <option value="2">caixa</option>
                                <option value="3">freezer</option>
                            </select>
                            <div class="invalid-feedback">Example invalid custom select feedback</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="validationServer02">Posição</label>
                        <input type="number" class="form-control is-valid" id="validationServer02" placeholder="" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div> 
                    <div class="col-md-1">
                        <label for="tipoLocalArmazenamento" style="color:red;"> Adicionar</label>
                        <form action="" method="post">
                            <button class="btn btn-primary" name="adicionar" type="submit">Submit form</button>
                        </form>
                    </div>


                </div>';
                
    }
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>CADASTRO LOCAL DE ARMAZENAMENTO</title>
        <!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />-->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

        <!-- HTML5Shiv -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <![endif]-->

        <!-- Estilo customizado -->
        <link rel="stylesheet" type="text/css" href="##">

        <!-- google fonts -->
        <link href="https://fonts.googleapis.com/css?family=Baloo+Chettan+2&display=swap" rel="stylesheet">
        <style>
            .formulario{
                margin: 50px;
            }
            
        </style>
    </head>
    <body>
        <div class="formulario">
            <form method="POST">
                <div class="form-group">
                    <select class="custom-select" required>
                        <option value="">Selecione o código da amostra</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="form-row">
                    <div class="col-md-4">
                        <label for="tipoAmostra">Tipo de amostra</label>
                        <div class="form-group">
                            <select class="custom-select" name="sel_tipoAmostra" required>
                                <option value="">Selecione o tipo da amostra</option>
                                <option value="congelada">congelada</option>
                                <option value="normal">normal</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="validationServer02">Quantidade de tubos</label>
                        <input type="number" class="form-control" id="validationServer02" name="numQntTubos" placeholder="" required>
                        <!--<div class="valid-feedback">
                            Looks good!
                        </div>-->
                    </div> 
                    <div class="col-md-2">
                        <label for="tipoLocalArmazenamento">Tipo do local de armazenamento</label>
                        <div class="form-group">
                            <select class="custom-select" name="sel_local" required>
                                <option value="">Selecione o local</option>
                                <option value="1">gaveta</option>
                                <option value="2">caixa</option>
                                <option value="3">freezer</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="validationServer02">Posição</label>
                        <input type="number" class="form-control " id="validationServer02" name="numPosicao" placeholder="" required>
                        <!--<div class="valid-feedback">
                            Looks good!
                        </div>-->
                    </div> 
                    <div class="col-md-1">
                        <label for="tipoLocalArmazenamento" style="color:red;"> Adicionar</label>
                        <button class="btn btn-primary" name="adicionar" type="submit">Submit form</button>
                    </div>


                </div>
                <?=$html?>
                
                
                </form>
                
        </div>


    </body>
</html>
