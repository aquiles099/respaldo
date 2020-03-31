@set('buttonPadding', 20)
@set('user')
@set('toolbar')
@set('only')
@set('noTitle')
@extends('pages.blank')
@section('pageTitle', trans('messages.logIn'))
@section('title', trans('messages.logIn'))
<script type="text/javascript">
var  verifyTerms = function () {
  $('#loginButton').attr('disabled','true');
  $('#loginButton').html('<i class="fa fa-circle-o-notch fa-spin"></i> Espere...');
  var url      = asset('login')+"/terms";
  var dataString =
    {
      'username' : $('#username').val(),
      'password' : $('#password').val()
    };
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        data: dataString,
        beforeSend: function ()
        {

        },
        success: function (json)
        {
         if((json.message)=='false'){
          loadButton();
         }else {
           $('#formulario').submit();
           //loadUserData();
           //console.log(terms);
         }
       }
      });
}

function changeBox(){

  if ($('#check').is(":checked") == true) {
    $('.checkTC').prop('disabled',false);
  }else {
    $('.checkTC').prop('disabled',true);
  }

}
var loadButton = function () {
    $('#loginButton').attr('disabled','true');
    $('#loginButton').html('<i class="fa fa-circle-o-notch fa-spin"></i> Espere...');
    //ANTES DE ABRIR EL BOOTBOX DEBE CONSULTAR SI NO HA  ACEPTADO LOS TC

    bootbox.confirm({
      title: "CONTRATO DE LICENCIA PARA USUARIOS FINALES DE ICS",
      backdrop: true,
      message: "<div style='overflow-y: scroll; max-height: 400px;'><center><b>IMPORTANTE: ESTO ES UNA LICENCIA, NO UNA VENTA</b></center><br>"+
  "<p style='text-align:justify;margin: 0 10 10px;'>A no ser que haya suscrito un acuerdo por escrito con <b><b>SOLID PROJECT SOLUTIONS</b> </b> en que se contemple algún uso adicional, el contrato siguiente le otorga permiso para <b>ACCEDER </b> y <b>USAR </b> este Producto conforme se estipula con mayor detalle a continuación.</p>"+
  "<p style='text-align:justify;margin: 0 10 10px;'><b>AVISO IMPORTANTE: LEA ESTE CONTRATO DE LICENCIA PARA USUARIOS FINALES CON ATENCIÓN. AL USAR EL SOFTWARE Y LA DOCUMENTACIÓN (EN ADELANTE, EL 'SOFTWARE'), O ACCEDER A ELLOS, USTED ACEPTA LAS CONDICIONES DE ESTE CONTRATO. SI NO ACEPTA LAS CONDICIONES DEL MISMO, ABSTÉNGASE DE USAR EL SOFTWARE Y/O ACCEDER A ÉL. ESTE CONTRATO CONTIENE EXCLUSIONES DE GARANTÍAS, LIMITACIONES DE RESPONSABILIDAD Y RECURSOS EXCLUSIVOS. LAS ESTIPULACIONES SIGUIENTES CONSTITUYEN EL FUNDAMENTO ESENCIAL DE NUESTRO ACUERDO. </p></b>"+
  "<p style='text-align:justify;margin: 0 10 10px;'>El presente es un contrato legal entre usted y <b><b>SOLID PROJECT SOLUTIONS</b></b>, incluidas las filiales, entidades afiliadas y contratistas que actúen en nuestro nombre (colectivamente, 'ICS', 'nos', 'nosotros', 'nuestro' o cualquier uso similar de la primera persona del plural) en relación con su uso del <b>Software</b>. A no ser que usted tenga otro contrato por escrito con <b><b>SOLID PROJECT SOLUTIONS</b></b> en relación con este <b>Software</b>, el uso que usted haga del mismo se regirá por este contrato. Cada cierto tiempo,"+
  " podremos actualizar o modificar este contrato según nuestro exclusivo criterio. La versión más reciente de este contrato se encuentra en esta dirección:  <a href='http://www.internationalcargosystem.com'>www.internationalcargosystem.com </a></p>"+
  "<p style='text-align:justify;margin: 0 10 10px;'><b>SI ACEPTA LAS CONDICIONES DE ESTE CONTRATO, SE LE OTORGA UNA LICENCIA LIMITADA, PERSONAL, DE ÁMBITO MUNDIAL, LIBRE DE REGALÍAS, NO ASIGNABLE, NO SUBLICENCIABLE, NO TRANSFERIBLE Y NO EXCLUSIVA PARA UTILIZAR EL SOFTWARE, CUYO USO PODRÁ SER LIMITADO EN EL TIEMPO SEGÚN SE ESTIPULA A CONTINUACIÓN. SE LE PERMITE UTILIZAR EL SOFTWARE PARA (A) FINES PROPIOS, PRIVADOS, NO COMERCIALES COMO USUARIO PRIVADO Y/O (B) PARA FINES COMERCIALES COMO PROVEEDOR DE SERVICIOS EN UN NEGOCIO COMERCIAL (EN ADELANTE,"+ "“USUARIO COMERCIAL”). ESTE SOFTWARE CONTARÁ CON UNA LICENCIA POR USUARIO (EN ADELANTE, “DIRECCIÓN”). SI HA ADQUIRIDO VARIAS LICENCIAS DE ACCESO Y USO DEL SOFTWARE, PODRÁ USAR EN CUALQUIER MOMENTO TANTAS COPIAS DEL SOFTWARE DE QUE SE TRATE (Y ACCEDER A ELLAS) COMO LICENCIAS TENGA.  </b></p>"+
  "</p><b><p style='text-align:justify;margin: 0 10 10px;'>1-<b>LICENCIA PARA UTILIZAR EL SOFTWARE</b></b>. El software no se le vende a usted, sino que se le otorga una licencia de uso. Deberá adquirir legalmente <b>el software</b> a través de nosotros o de nuestros distribuidores autorizados. De lo contrario, no tendrá derecho a utilizarlo. Solo podrá adquirir <b>el Software</b> a través de nuestro web site <a href='http://www.internationalcargosystem.com'>www.internationalcargosystem.com </a>, Una vez expirado el período gratuito de prueba, el uso ilimitado del <b>Software</b> quedará suspendido hasta que complete el proceso de "+ "activación y/o registro. <b><b>SOLID PROJECT SOLUTIONS</b></b> se reserva cualquier derecho que no se le otorgue expresamente a usted en virtud del presente contrato. <p style='text-align:justify;margin: 0 10 10px;'>"+
  "<p style='text-align:justify;margin: 0 10 10px;'><b>2-<b>RESPONSABILIDADES DEL USUARIO AL UTILIZAR EL SOFTWARE</b></b>. Usted tendrá determinadas responsabilidades relativas al uso del Software en virtud del presente contrato. El Software podrá incluir tecnología de activación de productos y otras tecnologías diseñadas para evitar usos y copias no autorizados. Queda prohibido vender, alquilar, arrendar, revender y prestar el Software. Si adquiere el Software como regalo para una tercera persona, dicha persona deberá aceptar las condiciones del presente"+
  "contrato antes de utilizar el Software. Queda prohibido someter el Software a procesos de ingeniería inversa, descompilación o desensamblaje. En relación con el uso que usted haga del Software, No podrá modificarlo ni crear trabajos derivados tomándolo como base. Usted declara y garantiza que cumplirá toda la normativa y la legislación aplicables que afecten al uso del Software, lo que incluye las leyes sobre protección de datos e intimidad. Se compromete a no utilizar el Software de ninguna"+ "manera ilegítima o que vulnere los derechos de terceros. Toda información que se ingrese, maneja y ejecute en su uso del software es de su propiedad exclusiva y por lo tanto es de su responsabilidad exclusiva cualquier efecto, daño o perjuicio que pueda derivar del uso, propagación y o emisión de tal información sin que <b><b>SOLID PROJECT SOLUTIONS</b></b> incurra en responsabilidad alguna de manera individual ni corresponsable. Usted se compromete a defender, indemnizar y exonerar de toda"+
  "responsabilidad a <b><b>SOLID PROJECT SOLUTIONS</b></b> en caso de que un tercero interponga una demanda o reclamación contra nosotros a causa de (a) sus acciones, (b) la omisión por su parte del deber de actuar cuando así se requiera o (c) su Contenido. Usted podrá recibir actualizaciones, parches para solucionar errores, mejoras de prestaciones y otros datos relativos al Software (en adelante y de forma colectiva, “Actualizaciones”) que se descargarán en su equipo informático con un aviso en el que se describirán el"+ "contenido y la finalidad de las Actualizaciones en cuestión. </p>"+
  "<p style='text-align:justify;margin: 0 10 10px;'><b>3-<b>COMENTARIOS GENERADOS POR LOS USUARIOS</b></b>. Usted no tiene ninguna obligación de proporcionar a <b><b>SOLID PROJECT SOLUTIONS</b></b> ideas, sugerencias, documentación ni propuestas (en adelante, “Comentarios”). No obstante, si envía Comentarios a <b><b>SOLID PROJECT SOLUTIONS</b></b>, y aunque usted conservará la propiedad de ellos, por el presente otorga a <b><b>SOLID PROJECT SOLUTIONS</b></b> una licencia no exclusiva, libre de regalías, totalmente pagada, perpetua, irrevocable, transferible e ilimitada sobre ellos al amparo de todos"+
  "sus derechos de propiedad intelectual para usar y explotar de cualquier otro modo sus Comentarios con cualquier finalidad y en todo el mundo. Además, al enviarnos Comentarios, usted manifiesta y garantiza lo siguiente: (i) sus Comentarios no contienen información confidencial ni propiedad suya ni de terceros; (ii) <b><b>SOLID PROJECT SOLUTIONS</b></b> no está sometido a ningún tipo de obligación de confidencialidad, explícita ni implícita, respecto a los Comentarios; (iii) <b><b>SOLID PROJECT SOLUTIONS</b></b>"+ "podría estar estudiando o desarrollando ya algo semejante a los Comentarios; y (iv) usted no tiene derecho en ninguna circunstancia a ningún tipo de remuneración ni reembolso por parte de <b><b>SOLID PROJECT SOLUTIONS</b></b> a cambio de los Comentarios. </p>"+
  "<p style='text-align:justify;margin: 0 10 10px;'><b>4-NUESTROS DERECHOS DE PROPIEDAD INTELECTUAL</b>. El Software está protegido por las leyes de propiedad intelectual de los Estados Unidos y Panamá, así como por los tratados y normas internacionales sobre propiedad intelectual. Por tanto, queda prohibido distribuir el Software sin nuestro permiso. No podrá copiar el Software ni los materiales impresos que lo acompañen (ni imprimir copias de ninguna documentación del usuario) para ningún otro fin. Usted acepta que tanto <b><b>SOLID PROJECT SOLUTIONS</b></b> como"+
  "sus logotipos y otras marcas comerciales, marcas de servicio y gráficos son marcas comerciales de <b><b>SOLID PROJECT SOLUTIONS</b></b> (algunas en Panamá y/o en otros países) o son marcas comerciales de los socios de <b><b>SOLID PROJECT SOLUTIONS</b></b> (en adelante, las 'Marcas'). No se le otorga el derecho a utilizar las Marcas sin el permiso del propietario. En ningún caso podrá eliminar, ocultar ni modificar ningún aviso de derecho de propiedad adherido o incluido en el Software. Usted entiende y acepta que"+
  "tenemos derecho a dejar de vender, distribuir, mantener o actualizar el Software (en su totalidad o en parte), así como otros servicios y ofertas, en cualquier momento.</p>"+
  "<p style='text-align:justify;margin: 0 10 10px;'><b>5-AUDITORÍAS DEL USO, PIRATERÍA Y POLÍTICA DE PRIVACIDAD</b>. Nuestras auditorías y la recopilación de sus datos o del uso que haga del Software se someterán a la política de privacidad de <b><b>SOLID PROJECT SOLUTIONS</b></b>. Podremos auditar el uso del Software para fines de lucha contra la piratería, para comprobar la validez de un registro, para identificar si hay nuevas Actualizaciones disponibles antes de enviarle un aviso al respecto y para evaluar el uso del Software. Usted otorga su consentimiento para"+
  "que el Software envíe datos sobre el uso (por ejemplo, el número de veces que se inicia el Software, la dirección IP de su dispositivo y/o la versión del Software) para fines de registro, autenticación, auditorías de uso y de lucha contra la piratería, y cumplimiento contractual. También podremos utilizar los datos de uso para nuestros propios fines internos estadísticos y analíticos, con el propósito de evaluar y mejorar la experiencia de los usuarios con el Software identificando las"+
  "preferencias y tendencias de compra de los usuarios, así como con fines de marketing y respecto a nuestras actividades de operaciones. </p>"+
  "<p style='text-align:justify;margin: 0 10 10px;'><b>6-AUSENCIA DE RESPONSABILIDAD POR DAÑOS INDIRECTOS O EMERGENTES. USTED ASUMIRÁ TODOS LOS COSTES DERIVADOS DE CUALQUIER DAÑO PRODUCIDO POR LA INFORMACIÓN CONTENIDA EN EL SOFTWARE O COMPILADA POR ÉL. EN LA MÁXIMA MEDIDA EN QUE LO PERMITA LA LEGISLACIÓN VIGENTE, <b>SOLID PROJECT SOLUTIONS</b>, SUS CEDENTES DE LICENCIA Y SUS PROVEEDORES NO SERÁN RESPONSABLES EN NINGÚN CASO POR NINGÚN TIPO DE DAÑOS Y PERJUICIOS (INCLUIDOS, SIN QUE SIRVA DE LIMITACIÓN, LOS DAÑOS Y PERJUICIOS POR LUCRO CESANTE, INTERRUPCIÓN"+
  "DEL NEGOCIO, PÉRDIDA DE INFORMACIÓN COMERCIAL U OTRAS PÉRDIDAS PECUNIARIAS) DERIVADOS DEL USO DEL SOFTWARE O DE LA INCAPACIDAD PARA UTILIZARLO, INCLUSO CUANDO LA PARTE EN CUESTIÓN HAYA SIDO INFORMADA DE LA POSIBILIDAD DE QUE SE PRODUZCAN DICHOS DAÑOS Y PERJUICIOS. LA RESPONSABILIDAD TOTAL DE <b>SOLID PROJECT SOLUTIONS</b> ANTE USTED POR TODOS LOS DAÑOS Y PERJUICIOS EN ATENCIÓN A UNO O VARIOS FUNDAMENTOS JURÍDICOS NO SUPERARÁ EN NINGÚN CASO LA CANTIDAD QUE USTED HAYA PAGADO POR EL"+
  "SOFTWARE. ESTA LIMITACIÓN SE APLICARÁ INDEPENDIENTEMENTE DE LOS POSIBLES FALLOS DEL PROPÓSITO FUNDAMENTAL DE CUALQUIER RECURSO JURÍDICO LIMITADO. ALGUNOS ESTADOS O PAÍSES NO PERMITEN LA LIMITACIÓN O EXCLUSIÓN DE RESPONSABILIDAD POR DAÑOS Y PERJUICIOS INDIRECTOS O EMERGENTES, POR LO QUE LA LIMITACIÓN ANTERIOR PODRÍA NO APLICARSE EN SU CASO</b>.</p> <p style='text-align:justify;margin: 0 10 10px;'> Las limitaciones anteriormente mencionadas se aplicarán independientemente de su fundamento jurídico, en particular en lo relativo a cualquier"+
  " obligación precontractual o vinculada a contratos auxiliares. No obstante, estas limitaciones no se aplicarán a ninguna responsabilidad obligatoria derivada de la legislación vigente sobre responsabilidad por productos defectuosos, ni tampoco a los daños y perjuicios derivados del incumplimiento de una garantía expresa en la medida en que dicha garantía expresa tuviera como finalidad proteger a los consumidores contra el daño concreto sufrido, ni tampoco se aplicarán a los daños y perjuicios causados por"+
  " fallecimiento, lesiones o perjuicios a la salud.</p>"+
  "<p style='text-align:justify;margin: 0 10 10px;'><b>7-CONDICIONES ADICIONALES DEL CONTRATO</b></p>"+
  "<p style='text-align:justify;margin: 0 10 10px;'><b>7.1-CONDICIONES ADICIONALES PARA LICENCIAS Y SUSCRIPCIONES DE PLAZO FIJO</b>: Con sujeción a lo dispuesto en los términos y condiciones del presente contrato, en caso de una licencia o suscripción de plazo fijo (fixed term license/subscription), la licencia para utilizar el Software empezará en la fecha de la compra y tendrá la duración establecida por <b>SOLID PROJECT SOLUTIONS</b> o por el distribuidor autorizado de <b>SOLID PROJECT SOLUTIONS</b> en la factura correspondiente. El uso del Software con"+ " anterioridad o después del plazo fijo correspondiente y cualquier intento de frustrar la función de desconexión de control del tiempo del Software supondrán un uso no autorizado y constituirán un incumplimiento esencial del presente contrato y de la legislación aplicable.</p>"+
  "<p style='text-align:justify;margin: 0 10 10px;'><b>Abril de 2017 (1.0)</b></p>"+
      "<span >"+
        "<input id='check' type='checkbox' name='' value='' onclick='changeBox()'><label>Confirmo que he leido y estoy de acuerdo con los terminos y condiciones descritos arriba</label><br><br>"+
      "</span>"+
      "<br><br> </div>",
      buttons: {
          cancel: {
              label: '<i class="fa fa-times"></i> Cancelar'
          },
          confirm: {
              disabled: 'true',
              label: '<i class="fa fa-check"></i> Aceptar',
              className: 'btn btn-primary checkTC'
          }
      },
      callback: function (result) {
        if(result) {
          if ($('#check').is(":checked") == true) {
            $('#formulario').submit();
          }else{
            if($('#check').is(":checked") == false)
              {
                bootbox.alert({
                  message: "Para poder usar ICS, usted debe confirmar que ha leido y acepta los terminos y condiciones",
                  size: 'medium'
                });
              }
            $('#loginButton').removeAttr('disabled','true');
            $('#loginButton').html('Ingresar');
          }
        }else{
            $('#loginButton').removeAttr('disabled','true');
            $('#loginButton').html('Ingresar');
        }
      }
    });
    changeBox();
}
</script>
@section('body')
<div class="row">
  <div class="col-md-4 col-md-offset-4">
    @include('sections.messages')
    <div class="login-panel panel panel-default shadow">
      <div class="panel-heading">
        <div class="text-center text-muted">
          <i aria-hidden="true" class="fa fa-sign-in"></i>
            {{trans('messages.logIn')}}
        </div>
      </div>
      <div class="panel-body">
        <form id="formulario"role="form" action="{{asset('/login')}}" method="post">
          <fieldset>
            <div class="form-group @include('errors.field-class', ['field' => 'username'])">
              <input id="username" class="form-control" placeholder="{{trans('messages.email')}}" name="username" type="text" autofocus maxlength="40" min="5" required="true" value="" value="{{Input::get('username')}}">
              @include('errors.field', ['field' => 'username'])
            </div>
            <div class="form-group @include('errors.field-class', ['field' => 'password'])">
              <input id="password" class="form-control" placeholder="{{trans('messages.password')}}" name="password" type="password" value="" maxlength="20" min="5" required="true">
              @include('errors.field', ['field' => 'password'])
            </div>
            <!-- Change this to a button or input when using this as a form -->
            <a href="{{asset('/recover-password')}}" style="font-size:14px;"class="btn text-red">{{trans('messages.recoverPassword')}}</a><br>

            <div class="col-md-2"></div>
            <button style="padding-left: 60px;padding-right: 60px;"onclick="verifyTerms()" id="loginButton" type="submit" class="btn btn-primary col-md-8">{{trans('messages.doLogIn')}}</button>
            <div class="col-md-2"> </div>
            <div class="col-md-3"></div>
            <br><br><br>
            <div class="col-md-2"></div>
            <div style="padding-left:74px;font-size:14px;">
              {{trans('messages.noAccount')}}
              <a class="btn" style="color:#23527c;" href="{{asset('/register')}}" id ="drdusr"> {{trans('messages.register')}}</a>
            </div>
            <div class="col-md-3">

            </div>
            <!-- <a href="{{asset('/help')}}" target="blank" class="btn pull-right" style="margin-right:10px">{{trans('messages.help')}}</a> -->
          </fieldset>
        </form>
      </div>
    </div>
  </div>
</div>
@stop
