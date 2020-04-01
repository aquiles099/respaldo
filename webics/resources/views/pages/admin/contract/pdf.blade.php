<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>{{$client->webpage}}-contract </title>
    <!-- Customize favicon-->
    <link rel="shortcut icon" type="image/png" href="{{asset('dist/img/favicon.png')}}"/>
  </head>
  <style>
    body {
      font-family: Arial, Helvetica, Verdana;
    }
    .page-break {
        page-break-after: always;
    }
    .ics-text-center {
      text-align: center;
    }
    .ics-width-30 {
      width: 30%;
    }
    .ics-font-body {
      font-weight: bold;
    }
    .ics-text-contract p {
      font-size: 11px;
      text-align: justify;
    }
    .ics-font-13 {
      font-size: 13px;
    }
    .ics-table-pdf {
      width: 100%
    }
  </style>
  <?php
    function translateMonth ($month) {
      if ($month === '01') {
        return trans('contract.january');
      }
      if ($month === '02') {
        return trans('contract.february');
      }
      if ($month === '03') {
        return trans('contract.march');
      }
      if ($month === '04') {
        return trans('contract.april');
      }
      if ($month === '05') {
        return trans('contract.may');
      }
      if ($month === '06') {
        return trans('contract.june');
      }
      if ($month === '07') {
        return trans('contract.july');
      }
      if ($month === '08') {
        return trans('contract.august');
      }
      if ($month === '09') {
        return trans('contract.september');
      }
      if ($month === '10') {
        return trans('contract.october');
      }
      if ($month === '11') {
        return trans('contract.november');
      }
      if ($month === '12') {
        return trans('contract.december');
      }
    }
   ?>
  <body>
    <!--Imagen y datos de cabecera-->
    <div class="ics-text-center">
      <!--Imagen-->
      <p>
        <img src="{{asset('dist/img/logo.png')}}" alt="" class="ics-width-30"/>
      </p>
      <!--texto de cabecera-->
      <p class="ics-font-13">
        CONTRATO DE LICENCIA PARA USO DE ICS
      </p>
      <!--Perfil [macro-micro]-->
      <p class="ics-font-13">
        PERFIL: <strong>{{$solicitude->profile ? strtoupper($solicitude->profile) : trans('messages.unknown')}}</strong>
      </p>
      <!--Numero de licencia-->
      <p class="ics-font-13">
        LICENCIA NRO: <strong>{{$contract->code ? $contract->code : trans('messages.unknown')}}</strong>
      </p>
    </div>
    <!--Parrafo 1-->
    <div class="ics-text-contract">
      <p>
        A no ser que haya suscrito un acuerdo por escrito con SOLID PROJECT SOLUTIONS en que se contemple algún uso adicional, el contrato siguiente le otorga permiso para ACCEDER y USAR este Producto conforme se estipula con mayor detalle a continuación.
      </p>
    </div>
    <!--Parrafo 2 -->
    <div class="ics-text-contract">
      <p>
        AVISO IMPORTANTE: LEA ESTE CONTRATO DE LICENCIA PARA USUARIOS FINALES CON ATENCIÓN. AL USAR EL SOFTWARE Y LA DOCUMENTACIÓN (EN ADELANTE, EL "SOFTWARE"), O ACCEDER A ELLOS, USTED ACEPTA LAS CONDICIONES DE ESTE CONTRATO. SI NO ACEPTA LAS CONDICIONES DEL MISMO, ABSTÉNGASE DE USAR EL SOFTWARE Y/O ACCEDER A ÉL. ESTE CONTRATO CONTIENE EXCLUSIONES DE GARANTÍAS, LIMITACIONES DE RESPONSABILIDAD Y RECURSOS EXCLUSIVOS. LAS ESTIPULACIONES SIGUIENTES CONSTITUYEN EL FUNDAMENTO ESENCIAL DE NUESTRO ACUERDO.
      </p>
    </div>
    <!--Parrafo 3 [nombre de la empresa]-->
    <div class="ics-text-contract">
      <p>
        El presente es un contrato legal entre <strong>{{$client->name ? strtoupper($client->name) : trans('messages.unknown')}}</strong> y <strong>SOLID PROJECT SOLUTIONS CORP</strong>, incluidas las filiales, entidades afiliadas y contratistas que actúen en nuestro nombre (colectivamente, "ICS", "nos", "nosotros", "nuestro" o cualquier uso similar de la primera persona del plural) en relación con su uso del Software. A no ser que usted tenga otro contrato por escrito con <strong>SOLID PROJECT SOLUTIONS CORP</strong> en relación con este Software, el uso que usted haga del mismo se regirá por este contrato. Cada cierto tiempo, podremos actualizar o modificar este contrato según nuestro exclusivo criterio. La versión más reciente de este contrato se encuentra en esta dirección: http://www.internationalcargosystem.com
      </p>
    </div>
    <!--Parrafo 4-->
    <div class="ics-text-contract">
      <p>
        SI ACEPTA LAS CONDICIONES DE ESTE CONTRATO, SE LE OTORGA UNA LICENCIA LIMITADA, PERSONAL, DE ÁMBITO MUNDIAL, LIBRE DE REGALÍAS, NO ASIGNABLE, NO SUBLICENCIABLE, NO TRANSFERIBLE Y NO EXCLUSIVA PARA UTILIZAR EL SOFTWARE, CUYO USO PODRÁ SER LIMITADO EN EL TIEMPO SEGÚN SE ESTIPULA A CONTINUACIÓN. SE LE PERMITE UTILIZAR EL SOFTWARE PARA (A) FINES PROPIOS, PRIVADOS, NO COMERCIALES COMO USUARIO PRIVADO Y/O (B) PARA FINES COMERCIALES COMO PROVEEDOR DE SERVICIOS EN UN NEGOCIO COMERCIAL (EN ADELANTE, “USUARIO COMERCIAL”). ESTE SOFTWARE CONTARÁ CON UNA LICENCIA POR USUARIO (EN ADELANTE, “DIRECCIÓN”). SI HA ADQUIRIDO VARIAS LICENCIAS DE ACCESO Y USO DEL SOFTWARE, PODRÁ USAR EN CUALQUIER MOMENTO TANTAS COPIAS DEL SOFTWARE DE QUE SE TRATE (Y ACCEDER A ELLAS) COMO LICENCIAS TENGA.
      </p>
    </div>
    <!--Parrafo 5-->
    <div class="ics-text-contract">
      <p>
        1-LICENCIA PARA UTILIZAR EL SOFTWARE. El software no se le vende a usted, sino que se le otorga una licencia de uso. Deberá adquirir legalmente el software a través de nosotros o de nuestros distribuidores autorizados. De lo contrario, no tendrá derecho a utilizarlo. Solo podrá adquirir el Software a través de nuestro web site WWW.INTERNATIONALCARGOSYSTEM.COM, Una vez expirado el período gratuito de prueba de 30 días, el uso ilimitado del Software quedará suspendido hasta que complete el proceso de activación y/o registro, una vez hecha la activación y habiendo pagado la misma empezará su período de licencia de uso de ICS, dicho período tendrá una vigencia adicional de gracia de treinta (30) más después de vencida cada cuota o el período total de licencia contratado por usted. <strong>SOLID PROJECT SOLUTIONS CORP</strong> se reserva cualquier derecho que no se le otorgue expresamente a usted en virtud del presente contrato.
      </p>
    </div>
    <!--Parrafo 6 [fecha de duracion de contrato]-->
    <div class="ics-text-contract">
      <p>
        1.1-PERIODO DE VIGENCIA DE LICENCIA. La licencia de uso sobre ICS otorgada a usted, entra en vigencia desde el momento del pago exigible y tiene una duración
        exacta de <strong>{{$contract->cut_off_date ? \Carbon\Carbon::parse($contract->cut_off_date)->diffInDays(\Carbon\Carbon::parse($contract->register_date)) : trans('messages.unknown')}}</strong> (días o meses), es decir, desde
        <strong>{{$contract->register_date ? \Carbon\Carbon::parse($contract->register_date)->format('d-m-Y')  : trans('messages.unknown')}}</strong> hasta
        <strong>{{$contract->cut_off_date ? \Carbon\Carbon::parse($contract->cut_off_date)->format('d-m-Y') : trans('messages.unknown')}}</strong>
        Período que expira invariablemente después de cumplido el lapso de gracia si usted no activa nuevamente su licencia mediante el
        pago de la misma.
      </p>
    </div>
    <!--Parrafo 7-->
    <div class="ics-text-contract">
      <p>
        2-PERSONALIZACIÓN CORPORATIVA. El software le otorga una sesión personalizada y modificable en apariencia e identidad corporativa, a lo que el Licenciatario puede adecuar, incluir y modificar anexando sus elementos de identidad visual corporativa como logotipos, isotipos, nombres propios, etc; sin que esto signifique una exclusión de propiedad de <strong>SOLID PROJECT SOLUTIONS CORP</strong> sobre el software, todas veces que la personalización visual solo representa una adecuación de carácter de identificación gráfica para dar pertinencia en la prestación de sus servicios.
      </p>
    </div>
    <!--Parrafo 8-->
    <div class="ics-text-contract">
      <p>
        3-RESPONSABILIDADES DEL USUARIO AL UTILIZAR EL SOFTWARE. Usted tendrá determinadas responsabilidades relativas al uso del Software en virtud del presente contrato. El Software podrá incluir tecnología de activación de productos y otras tecnologías diseñadas para evitar usos y copias no autorizados. Queda prohibido vender, alquilar, arrendar, revender y prestar el Software. Si adquiere el Software como regalo para una tercera persona, dicha persona deberá aceptar las condiciones del presente contrato antes de utilizar el Software. Queda prohibido someter el Software a procesos de ingeniería inversa, descompilación o desensamblaje. En relación con el uso que usted haga del Software, No podrá modificarlo ni crear trabajos derivados tomándolo como base. Usted declara y garantiza que cumplirá toda la normativa y la legislación aplicables que afecten al uso del Software, lo que incluye las leyes sobre protección de datos e intimidad. Se compromete a no utilizar el Software de ninguna manera ilegítima o que vulnere los derechos de terceros. Toda información que se ingrese, maneja y ejecute en su uso del software es de su propiedad exclusiva y por lo tanto es de su responsabilidad exclusiva cualquier efecto, daño o perjuicio que pueda derivar del uso, propagación y o emisión de tal información sin que <strong>SOLID PROJECT SOLUTIONS CORP</strong> incurra en responsabilidad alguna de manera individual ni corresponsable. .Usted se compromete a defender, indemnizar y exonerar de toda responsabilidad a <strong>SOLID PROJECT SOLUTIONS CORP</strong> en caso de que un tercero interponga una demanda o reclamación contra nosotros a causa de (a) sus acciones, (b) la omisión por su parte del deber de actuar cuando así se requiera o (c) su Contenido. Usted podrá recibir actualizaciones, parches para solucionar errores, mejoras de prestaciones y otros datos relativos al Software (en adelante y de forma colectiva, “Actualizaciones”) que se descargarán en su equipo informático con un aviso en el que se describirán el contenido y la finalidad de las Actualizaciones en cuestión.
      </p>
    </div>
    <!--Parrafo 9-->
    <div class="ics-text-contract">
      <p>
        4-COMENTARIOS GENERADOS POR LOS USUARIOS. Usted no tiene ninguna obligación de proporcionar a SOLID PROJECT SOLUTIONS ideas, sugerencias, documentación ni propuestas (en adelante, “Comentarios”). No obstante, si envía Comentarios a <strong>SOLID PROJECT SOLUTIONS CORP</strong>, y aunque usted conservará la propiedad de ellos, por el presente otorga a <strong>SOLID PROJECT SOLUTIONS CORP</strong> una licencia no exclusiva, libre de regalías, totalmente pagada, perpetua, irrevocable, transferible e ilimitada sobre ellos al amparo de todos sus derechos de propiedad intelectual para usar y explotar de cualquier otro modo sus Comentarios con cualquier finalidad y en todo el mundo. Además, al enviarnos Comentarios, usted manifiesta y garantiza lo siguiente: (i) sus Comentarios no contienen información confidencial ni propiedad suya ni de terceros; (ii) <strong>SOLID PROJECT SOLUTIONS CORP</strong> no está sometido a ningún tipo de obligación de confidencialidad, explícita ni implícita, respecto a los Comentarios; (iii) <strong>SOLID PROJECT SOLUTIONS CORP</strong> podría estar estudiando o desarrollando ya algo semejante a los Comentarios; y (iv) usted no tiene derecho en ninguna circunstancia a ningún tipo de remuneración ni reembolso por parte de <strong>SOLID PROJECT SOLUTIONS CORP</strong> a cambio de los Comentarios.
      </p>
    </div>
    <!--Parrafo 10-->
    <div class="ics-text-contract">
      <p>
        5-NUESTROS DERECHOS DE PROPIEDAD INTELECTUAL. El Software está protegido por las leyes de propiedad intelectual de Panamá, así como por los tratados y normas internacionales sobre propiedad intelectual. Por tanto, queda prohibido distribuir el Software sin nuestro permiso. No podrá copiar el Software ni los materiales impresos que lo acompañen (ni imprimir copias de ninguna documentación del usuario) para ningún otro fin. Usted acepta que tanto <strong>SOLID PROJECT SOLUTIONS CORP</strong> como sus logotipos y otras marcas comerciales, marcas de servicio y gráficos son marcas comerciales de <strong>SOLID PROJECT SOLUTIONS CORP</strong> (algunas en Panamá y/o en otros países) o son marcas comerciales de los socios de <strong>SOLID PROJECT SOLUTIONS CORP</strong> (en adelante, las "Marcas"). No se le otorga el derecho a utilizar las Marcas sin el permiso del propietario. En ningún caso podrá eliminar, ocultar ni modificar ningún aviso de derecho de propiedad adherido o incluido en el Software. Usted entiende y acepta que tenemos derecho a dejar de vender, distribuir, mantener o actualizar el Software (en su totalidad o en parte), así como otros servicios y ofertas, en cualquier momento.
      </p>
    </div>
    <!--Parrafo 11-->
    <div class="ics-text-contract">
      <p>
        6-AUDITORÍAS DEL USO, PIRATERÍA Y POLÍTICA DE PRIVACIDAD. Nuestras auditorías y la recopilación de sus datos o del uso que haga del Software se someterán a la política de privacidad de <strong>SOLID PROJECT SOLUTIONS CORP</strong>. Podremos auditar el uso del Software para fines de lucha contra la piratería, para comprobar la validez de un registro, para identificar si hay nuevas Actualizaciones disponibles antes de enviarle un aviso al respecto y para evaluar el uso del Software. Usted otorga su consentimiento para que el Software envíe datos sobre el uso (por ejemplo, el número de veces que se inicia el Software, la dirección IP de su dispositivo y/o la versión del Software) para fines de registro, autenticación, auditorías de uso y de lucha contra la piratería, y cumplimiento contractual. También podremos utilizar los datos de uso para nuestros propios fines internos estadísticos y analíticos, con el propósito de evaluar y mejorar la experiencia de los usuarios con el Software identificando las preferencias y tendencias de compra de los usuarios, así como con fines de marketing y respecto a nuestras actividades de operaciones y
      </p>
    </div>
    <!--Parrafo 12-->
    <div class="ics-text-contract">
      <p>
        7-AUSENCIA DE RESPONSABILIDAD POR DAÑOS INDIRECTOS O EMERGENTES. USTED ASUMIRÁ TODOS LOS COSTES DERIVADOS DE CUALQUIER DAÑO PRODUCIDO POR LA INFORMACIÓN CONTENIDA EN EL SOFTWARE O COMPILADA POR ÉL O EMITIDA POR USTED CON SU USO; <strong>SOLID PROJECT SOLUTIONS CORP</strong>, SUS CEDENTES DE LICENCIA Y SUS PROVEEDORES NO SERÁN RESPONSABLES EN NINGÚN CASO POR NINGÚN TIPO DE DAÑOS Y PERJUICIOS (INCLUIDOS, SIN QUE SIRVA DE LIMITACIÓN, LOS DAÑOS Y PERJUICIOS POR LUCRO CESANTE, INTERRUPCIÓN DEL NEGOCIO, PÉRDIDA DE INFORMACIÓN COMERCIAL U OTRAS PÉRDIDAS PECUNIARIAS) DERIVADOS DEL USO DEL SOFTWARE O DE LA INCAPACIDAD PARA UTILIZARLO, INCLUSO CUANDO LA PARTE EN CUESTIÓN HAYA SIDO INFORMADA DE LA POSIBILIDAD DE QUE SE PRODUZCAN DICHOS DAÑOS Y PERJUICIOS. LA RESPONSABILIDAD TOTAL DE SOLID PROJECT SOLUTIONS ANTE USTED POR TODOS LOS DAÑOS Y PERJUICIOS EN ATENCIÓN A UNO O VARIOS FUNDAMENTOS JURÍDICOS NO SUPERARÁ EN NINGÚN CASO LA CANTIDAD QUE USTED HAYA PAGADO POR EL SOFTWARE. ESTA LIMITACIÓN SE APLICARÁ INDEPENDIENTEMENTE DE LOS POSIBLES FALLOS DEL PROPÓSITO FUNDAMENTAL DE CUALQUIER RECURSO JURÍDICO LIMITADO. ALGUNOS ESTADOS O PAÍSES NO PERMITEN LA LIMITACIÓN O EXCLUSIÓN DE RESPONSABILIDAD POR DAÑOS Y PERJUICIOS INDIRECTOS O EMERGENTES, POR LO QUE LA LIMITACIÓN ANTERIOR PODRÍA NO APLICARSE EN SU CASO. Las limitaciones anteriormente mencionadas se aplicarán independientemente de su fundamento jurídico, en particular en lo relativo a cualquier obligación precontractual o vinculada a contratos auxiliares. No obstante, estas limitaciones no se aplicarán a ninguna responsabilidad obligatoria derivada de la legislación vigente sobre responsabilidad por productos defectuosos, ni tampoco a los daños y perjuicios derivados del incumplimiento de una garantía expresa en la medida en que dicha garantía expresa tuviera como finalidad proteger a los consumidores contra el daño concreto sufrido, ni tampoco se aplicarán a los daños y perjuicios causados por fallecimiento, lesiones o perjuicios a la salud.
      </p>
    </div>
    <!--Parrafo 13-->
    <div class="ics-text-contract">
      <p>
        8-CONDICIONES ADICIONALES DEL CONTRATO
      </p>
    </div>
    <!--Parrafo 14-->
    <div class="ics-text-contract">
      <p>
        8.1-CONDICIONES ADICIONALES PARA LICENCIAS Y SUSCRIPCIONES DE PLAZO FIJO: Con sujeción a lo dispuesto en los términos y condiciones del presente contrato, en caso de una licencia o suscripción de plazo fijo (fixed term license/subscription), la licencia para utilizar el Software empezará en la fecha de la compra y tendrá la duración establecida por <strong>SOLID PROJECT SOLUTIONS CORP</strong> o por el distribuidor autorizado de <strong>SOLID PROJECT SOLUTIONS CORP</strong> en la factura correspondiente. El uso del Software con anterioridad o después del plazo fijo correspondiente y cualquier intento de frustrar la función de desconexión de control del tiempo del Software supondrá un uso no autorizado y constituirán un incumplimiento esencial del presente contrato y de la legislación aplicable.
      </p>
    </div>
    <!--Parrafo 15-->
    <div class="ics-text-contract">
      <p>
        ESTE CONTRATO SE SUSCRIBE CON EL PLENO CONOCIMIENTO Y ACEPTACIÓN DE ESTOS Y OTROS TÉRMINOS QUE HAYA ESTABLECIDO <strong>SOLID PROJECT SOLUTIONS CORP</strong> EN OTROS ÁMBITOS IMPRESOS O DIGITALES CON EL SUSCRIBIENTE. TIENE EFECTO UNIVERSAL Y REPRESENTA LA VOLUNTAD DE LAS PARTES. A FIN DE DAR EFECTO A LOS MISMOS, LAS PARTES QUEDAN BAJO LOS EFECTOS DE ESTE CONTRATO A PARTIR DE SU IMPRESIÓN DIGITAL LUEGO DE ACEPTAR EL ACCESO AL SOFTWARE POR MEDIO DEL PAGO DEL MISMO
      </p>
    </div>
    <!--Parrafo 16-->
    <div class="ics-text-contract">
      <p>
        QUIENES SUSCRIBEN
      </p>
    </div>
    <!--Parrafo 17-->
    <div class="ics-text-contract">
      <table class="ics-table-pdf">
        <tr>
          <td style="font-size: 12px">
            _______________________________
          </td>
          <td style="font-size: 12px">
            <strong>SOLID PROJECT SOLUTIONS CORP</strong>
          </td>
        </tr>
      </table>
    </div>
    <!--Parrafo 15-->
    <div class="ics-text-contract">
      <p>
        Ciudad de Panamá, <strong>{{\Carbon\Carbon::today()->format('d')}} de {{translateMonth(\Carbon\Carbon::today()->format('m'))}} de {{\Carbon\Carbon::today()->format('Y')}}</strong> (2.0)
      </p>
    </div>
  </body>
</html>
