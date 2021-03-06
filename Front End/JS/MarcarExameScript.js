//Script para tratar a página de MarcarExames

var request = "";
var horarios = ['08:00:00', '08:30:00', '09:00:00', '09:30:00', '10:00:00', '10:30:00', '11:00:00', '11:30:00', '13:00:00', '13:30:00', '14:00:00'];
//var mostrar = ['08:00:00', '08:30:00'];
var disponivel = ['08:00:00', '08:30:00', '09:00:00', '09:30:00', '10:00:00', '10:30:00', '11:00:00', '11:30:00', '13:00:00', '13:30:00', '14:00:00'];
var retornancia;

//tratar data como uma data
//data = new Date(document.getELementsById().value)
//tratar o campo CPF, para receber apenas 14 números, e calcular se o cpf é válido
//tratar o campo de e-mail, para ter @ e .com
//completar os vetores horarios e disponivel
//tratar o erro de hor_fim

function SelecionarData(){

    if(document.getElementById('data').value == "" || document.getElementById('data').value == null){
        alert("Escolha uma data");
    }else{

        new Object(Data = {
            data: document.getElementById('data').value,
        });
        
        var str_json = JSON.stringify(Data);

        request= new XMLHttpRequest();
        request.open("PUT", "http://localhost/TCC/PHP/ConsultarDataHorario.php", true);
        request.setRequestHeader("Content-type", "application/json");
        request.send(str_json);
        request.onload = function() {
            //disponivel = []; ATENÇÃO!!!
            if(request.status == 200){
                var retorno = JSON.parse(request.response);
                //console.log(retorno[1]);
                for(var i=0; i<=horarios.length-1; i++){
                    for(var ii=0; ii<=retorno.length-1; ii++){
                        //console.log('retorno['+ii+']: '+retorno[ii]['ocupado']);
                        //console.log('horarios['+i+']: '+horarios[i]);
                        if(horarios[i] == retorno[ii]["ocupado"]){
                            //console.log(disponivel[1]);
                            disponivel.splice(ii,1);
                            //console.log(disponivel);
                            //disponivel[disponivel.length] = horarios[i];
                        }
                    }
                }
                Exibir();
            }
        };
    }
}

function Exibir(){
    var html = "";
    var tag = "";
    //console.log(disponivel);

    for(var i=0; i<=disponivel.length-1; i++){
        tag = tag+" "+"<option value='"+disponivel[i]+"'>"+disponivel[i]+"</option>";
    }

    html = "<select id='horas'> <option value='' default> Selecione </option>"+tag+"</select> <button Onclick='PegarExames()'>Próximo</button>";
    document.getElementById('horarios').innerHTML=html;

}

function PegarHora(){
    var hora = document.getElementById('horas').value;
    return hora;
}

function PegarExames(){

    request = "";
    request= new XMLHttpRequest();
    request.open("GET", "http://localhost/TCC/PHP/ConsultarExames.php", true);
    request.setRequestHeader("Content-type", "application/json");
    request.send();
    request.onload = function() {
        if(request.status == 200){
            retornancia = JSON.parse(request.response);
        }
        ExibirFormulario()
    }
}

function ExibirFormulario(){
    if(document.getElementById('horas').value == "" || document.getElementById('horas').value == null){
        alert("Selecione um Horário!");
    }else{
        html = "<h2>Agora, insira alguns dados</h2><p>Nome</p><input type='text' id='nome'></br><p>CPF</p><input type='text' id='cpf'></br><p>Data de Nascimento</p><input type='date' id='dt_nasc'><p>E-mail</p><input type='email' id='email'><p>Telefone</p><input type='number' id='telefone'>";
        document.getElementById('formulario').innerHTML=html;
        ExibirExames();
    }
}


function ExibirExames(){
    var tag = "";
    var html = "";

    for(i=0; i<=retornancia.length-1; i++){
        tag = tag +" "+"<option value='"+retornancia[i].nome+"'>"+retornancia[i].nome+"</option>";
    }
    
    html = "<p>Exame</p><select id='exame'> <option value='' default> Selecione </option>"+tag+"</select></br><button onclick='EnviarFormulario()'>Enviar</button>";
    document.getElementById('exames').innerHTML=html;
}

function HoraFim(){
    hora_ini = new Date(document.getElementById('horas').value);
    alert(hora_ini);
    hora_fim = new Date;

    hora_ini.setHours(document.getElementById('horas').value);
    hora_fim.setMinutes(hora_ini.getMinutes + 30);


    //hora_ini = hora_ini.getHours(document.getElementById('horas').value);
}

function HoraFim(hor_ini, data){
    hor_ini_result = hor_ini.split("");
    data_result = data.split("");

    dia = data_result[8]+data_result[9];
    mes =  parseInt(data_result[5]+data_result[6])-1;
    ano =  data_result[0]+data_result[1]+data_result[2]+data_result[3];
    hora = hor_ini_result[0]+hor_ini_result[1];
    minuto = hor_ini_result[3]+hor_ini_result[4];
    segundo = hor_ini_result[6]+hor_ini_result[7];

    inicio = new Date(ano, mes, dia, hora, minuto, segundo, 00);

    fim = new Date(inicio);
    fim.setMinutes(fim.getMinutes()+30);

    return fim;

}


function EnviarFormulario(){
    
    if(document.getElementById('nome').value == "" || document.getElementById('nome').value == null){
        alert("Preencha o campo de nome");
    }else if(document.getElementById('cpf').value == "" || document.getElementById('cpf').value == null){
        alert("Preencha o campo de cpf");
    }else if(document.getElementById('dt_nasc').value == "" || document.getElementById('dt_nasc').value == null){
        alert("Preencha o campo de Data de Nascimento");
    }else if(document.getElementById('email').value == "" || document.getElementById('email').value == null){
        alert("Preencha o campo de email");
    }else if(document.getElementById('telefone').value == "" || document.getElementById('telefone').value == null){
        alert("Preencha o campo de telefone");
    }else if(document.getElementById('exame').value == "" || document.getElementById('exame').value == null){
        alert("Preencha o campo de Exames");
    }else{
        new Object(formulario = {
            nome: document.getElementById('nome').value,
            cpf: document.getElementById('cpf').value,
            dt_nasc: document.getElementById('dt_nasc').value,
            email: document.getElementById('email').value,
            telefone: document.getElementById('telefone').value == "",
            exame: document.getElementById('exame').value,
            hor_ini: document.getElementById('horas').value,
            hor_fim: HoraFim(document.getElementById('horas').value, document.getElementById('data').value),
            data: document.getElementById('data').value
        });

        var str_JSON = JSON.stringify(formulario);

        request = "";
        request= new XMLHttpRequest();
        request.open("POST", "http://localhost/TCC/PHP/EnviarFormularioExames.php", true);
        request.setRequestHeader("Content-type", "application/json");
        request.send(str_JSON);
        request.onload = function() {
            if(request.status == 200){
                console.log(request.response);
                retornancia = JSON.parse(request.response);
                console.log(retornancia);
            }
        //ExibirFormulario()
    }

        //console.log(formulario);
        //testar se o objeto deu certo
    }
}
