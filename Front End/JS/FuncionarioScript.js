//Script da tela de funcionario

window.onload = ColetarData(); 

function ColetarData(){

    var atual = new Date;
    var data = '';
    var mes = atual.getMonth()+1;

    if(atual.getMonth()<10){
        data = atual.getFullYear()+'-0'+mes;
    }else{
        data = atual.getFullYear()+'-'+mes;
    }
    
    if(atual.getDay()<10){
        data = data+'-0'+atual.getDay();
    }else{
        data = data+'-'+atual.getDay();
    }
    
    new Object(dados = {
        data: data
    });

    Consultar(dados, 'SelecionarExames');
    
}

function Consultar(dados, pagina){
    
    var str_json = JSON.stringify(dados);

    request = "";
    request= new XMLHttpRequest();
    request.open("POST", "http://localhost/TCC/PHP/"+pagina+".php", true);
    request.setRequestHeader("Content-type", "application/json");
    request.send(str_json);
    request.onload = function() {
        if(request.status == 200){
            retorno = JSON.parse(request.response);
            ExibirExames(retorno, 'Exames');
            Consulta2(dados, 'ConsultarConsultas');
        }
    }
}

function Consulta2(dados, pagina){
    
    var str_json = JSON.stringify(dados);

    request = "";
    request= new XMLHttpRequest();
    request.open("POST", "http://localhost/TCC/PHP/"+pagina+".php", true);
    request.setRequestHeader("Content-type", "application/json");
    request.send(str_json);
    request.onload = function() {
        if(request.status == 200){
            retorno = JSON.parse(request.response);
           ExibirConsultas(retorno, 'Consultas');
        }
    }
}

function ExibirExames(retorno, id){

    var linha = '';

    for(var i=0; i<=retorno.length-1; i++){
        linha += "<tr><td>"+retorno[i]['nome']+"</td><td>"+retorno[i]['email']+"</td><td>"+retorno[i]['telefone']+"</td><td>"+retorno[i]['exame']+"</td><td>"+retorno[i]['hor_ini']+"</td></tr>";
    }

    var html = "<table border='1'><tr><th>Nome</th><th>E-mail</th><th>Telefone</th><th>Exame</th><th>Horário</th></tr>"+linha+"</table>";
    document.getElementById(id).innerHTML=html;
}

function ExibirConsultas(retorno, id){

    var linha = '';

    for(var i=0; i<=retorno.length-1; i++){
        linha += "<tr><td>"+retorno[i]['nome']+"</td><td>"+retorno[i]['email']+"</td><td>"+retorno[i]['telefone']+"</td><td>"+retorno[i]['especialidade']+"</td><td>"+retorno[i]['hor_ini']+"</td></tr>";
    }

    var html = "<table border='1'><tr><th>Nome</th><th>E-mail</th><th>Telefone</th><th>Especialidade</th><th>Horário</th></tr>"+linha+"</table>";
    document.getElementById(id).innerHTML=html;
}
