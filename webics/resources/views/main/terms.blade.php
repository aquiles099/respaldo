@section('title-page', trans('messages.terms'))
@section('keywords', trans('messages.termskeywords'))
<!--Meta Facebook-->
@section('meta-facebook')
<meta property="og:title" content="{{trans('messages.ICS')}} - {{trans('messages.terms')}}">
<meta property="og:description" content="{{trans('messages.slogan')}} - {{trans('messages.terms')}}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{asset('/terms')}}">
<meta property="og:image" content="{{asset('dist/img/favicon.png')}}">
<meta property="og:image:width" content="250">
<meta property="og:image:height" content="250">
<meta property="og:site_name" content="{{trans('messages.ICS')}} - {{trans('messages.terms')}}">
@stop
<!--Meta Twitter-->
@section('meta-twitter')
<meta name="twitter:card"  content="summary">
<meta name="twitter:site"  content="{{env('ICS_TWITTER_URL')}}">
<meta name="twitter:title" content="{{trans('messages.ICS')}} - {{trans('messages.terms')}}">
<meta name="twitter:creator" content="{{env('ICS_SPS_URL')}}" />
<meta name="twitter:description" content="{{trans('messages.slogan')}} - {{trans('messages.terms')}}">
<meta property="og:image" content="{{asset('dist/img/favicon.png')}}">
<meta property="og:image:width" content="250">
<meta property="og:image:height" content="250">
@stop
@extends('layouts.main.master')
@section('body')
<section id="contact" class="section gray">
  <div class="container">
  	<div class="blankdivider30"></div>
  	<h4>{{trans('messages.terms')}}</h4>
  	<div class="row">
  		<div class="span12" style="color: black">
        <!---->
        <h1 style="text-align: center">
					<img src="{{asset('dist/img/logo.png')}}" style="height: 100px;">
        </h1>
        <!---->
        <div class="">
          <p class="icstextterms">
            Términos
            y
            Condiciones
            del
            acuerdo
            de
            uso
            del
            sitio
            web,
            Bienvenido!
            Por favor lea atentamente estos términos y condiciones antes de proseguir con la
            navegación en nuestro web site.
            Mientras usted navega por este sitio web, o envía de alguna forma cualquier
            información a www.internationalcargosystem.com (ICS), usted acepta, y
            suscribe el acuerdo de sujetarse a los términos y condiciones que aparecen a
            continuación. Si usted no está de acuerdo con los Términos y Condiciones a
            continuación,
            debe
            salir
            de
            este
            sitio
            web
            inmediatamente.
          </p>
        </div>
        <!--1-->
        <div>
          <p class="icstextterms">
            <strong>1. Aceptación</strong>
          </p>
          <p class="icstextterms">
            <strong>1.1.</strong> Este acuerdo significa que usted está de acuerdo con <strong>SOLID PROJECT
            SOLUTIONS CORP</strong> respecto al uso que haga del sitio web de ICS. Según esto,
            debe usted acatar todos los términos y condiciones contenidos en este Acuerdo con
            el objetivo de seguir visualizando o utilizando el sitio web de ICS.
          </p>
          <p class="icstextterms">
            <strong>1.2.</strong> <strong>SOLID PROJECT SOLUTIONS CORP</strong> se reserva el derecho de cambiar,
            modificar, agregar o eliminar cualquier fragmento de este Acuerdo, el todo o en
            partes, en cualquier momento bajo su única y absoluta discreción.
          </p>
          <p class="icstextterms">
            <strong>1.3.</strong> Los cambios realizados a este Acuerdo
            serán publicados en
            www.internationalcargosystem.com (el sitio web). Cualquier uso continuado que
            usted realice del sitio web en esta dirección después que se ha realizado algún
            cambio,
            implica
            su
            aceptación
            sobre
            estos
            cambios.
          </p>
        </div>
        <!--2-->
        <div class="">
          <p class="icstextterms">
            <strong>2. Derecho de Autor; Marca</strong>
          </p>
          <p class="icstextterms">
            <strong>2.1.</strong> El sitio web está protegido por derechos de autor de conformidad con las leyes
            de derecho de autor de Panamá, convenios internacionales y otras leyes de
            derechos de autor. Todos los materiales contenidos en el sitio web están protegidos
            por derecho de autor y son propiedad de <strong>SOLID PROJECT SOLUTIONS CORP</strong>,
            junto con las partes que proveen los contenidos. Usted debe respetar cualquier
            aviso adicional sobre los derechos de autor, información, o restricciones contenidas
            en cualquier parte del sitio web. Se prohíbe expresamente copiar o almacenar
            alguna parte del sitio web, sin permiso previo por escrito de Ingbasica o del dueño
            de
            los
            derechos
            de
            autor
            de
            dichos
            contenidos.
          </p>
          <p class="icstextterms">
            <strong>2.2.</strong> es una marca o marca registrada de <strong>SOLID PROJECT SOLUTIONS CORP</strong>. Usted debe estar de acuerdo en no eliminar cualquier marca registrada o
              nota similar de cualquier contenido que usted obtenga de este sitio web. Cualquier
              pregunta concerniente al uso de estas marcas registradas, o para conocer si otras
              marcas registradas que no aparecen en esta lista son propiedad de SOLID
              PROJECT SOLUTIONS CORP usted debe contactarnos a través de la dirección de
              correo
              electrónico
              info@internationalcargosystem.com
          </p>
        </div>
        <!--3-->
        <div class="">
          <p class="icstextterms">
            <strong>3. Cambios en el sitio web; Utilización.</strong>
          </p>
          <p class="icstextterms">
            <strong>SOLID PROJECT SOLUTIONS CORP</strong> puede modificar, suspender o descontinuar
              cualquier aspecto del sitio web en cualquier momento. SOLID PROJECT
              SOLUTIONS CORP puede también imponer límites a ciertas características y
              servicios, o restringir accesos a todo o partes del sitio web, sin previa notificación o
              responsabilidad
          </p>
        </div>
        <!--4-->
        <div class="">
          <p class="icstextterms">
            <strong>4. Representaciones y Garantías. Usted declara, garantiza y acuerda que:</strong>
          </p>
          <p class="icstextterms">
            <strong>4.1.</strong> Usted tiene, al menos, dieciocho años de edad; y no subirá, transmitirá,
            distribuirá o publicará de alguna otra forma a través del sitio web, ningún material
            que:
          </p>
          <p class="icstextterms">
            <strong>4.2.</strong> Restringe o inhibe a cualquier otro usuario de utilizar y disfrutar del sitio web;
          </p>
          <p class="icstextterms">
            <strong>4.3.</strong> Es ilícito, amenazante, abusivo, difamatorio, obsceno, pornográfico, profano o indecente;
          </p>
          <p class="icstextterms">
            <strong>4.4.</strong> Que constituya o aliente una conducta que pueda constituir un delito criminal,
              dar lugar a responsabilidad civil o violar la ley de alguna manera;
          </p>
          <p class="icstextterms">
            <strong>4.5.</strong> Que viole, plagie o infrinja los derechos de un tercero incluyendo, sin
              limitación, derechos de autor, marcas registradas, patentes, derechos de privacidad
              o
              publicidad,
              o
              cualquier
              otro
              derecho
              de
              un
              tercero;
          </p>
          <p class="icstextterms">
            <strong>4.6.</strong> Que contenga un virus o componente dañino o potencialmente dañino;
          </p>
          <p class="icstextterms">
            <strong>4.7.</strong> Que contenga información sobre anuncios publicitarios de cualquier tipo; y/o
          </p>
          <p class="icstextterms">
            <strong>4.8.</strong> Que constituya o contenga indicaciones falsas o engañosas de origen o falso
              testimonio.
          </p>
        </div>
        <!--5-->
        <div class="">
          <p class="icstextterms">
            <strong>5. </strong> sin aprobaciones <strong>SOLID PROJECT SOLUTIONS CORP</strong>. no representa ni
              aprueba la precisión o confiabilidad de ningún mensaje, consejo, opinión,
              declaración, memorándum, u otra información mostrada y distribuida a través del
              sitio web. Usted reconoce que es el único responsable de confiar, o no, en cualquier
              mensaje, consejo, opinión, declaración, memorándum o información. SOLID
              PROJECT SOLUTIONS CORP. se reserva el derecho, en su única y absoluta
              discreción, de corregir cualquier error u omisión en cualquier parte del sitio web. Así
              mismo SOLID PROJECT SOLUTIONS CORP no tiene la obligación de corregir
              ningún error u omisión que ocurra en alguna parte del sitio web.
          </p>
        </div>
        <!--6-->
        <div class="">
          <p class="icstextterms">
            <strong>6. Enlaces.</strong>
          </p>
          <p class="icstextterms">
            <strong>6.1.</strong> El sitio web contiene hipervínculos a otros sitios web. Si usted hace uso de
            estos hipervínculos para acceder a estos otros sitios web, usted navegara fuera de
            nuestro sitio web y su explorador de internet será redireccionado a otros sitios web.
            <strong>SOLID PROJECT SOLUTIONS CORP</strong>. no garantiza la confiabilidad o autenticidadde otros sitios web. Los hipervínculos a otros sitios web no constituyen una
            aprobación de <strong>SOLID PROJECT SOLUTIONS CORP</strong>. hacia estos sitios, su
            contenido o alguno de sus recursos. <strong>SOLID PROJECT SOLUTIONS CORP</strong>. solo
            provee estos hipervínculos para su conveniencia.
          </p>
          <p class="icstextterms">
            <strong>6.2.</strong> Cualquier otro sitio web que contenga un enlace a nuestros sitios web: (i) No
              debe crear un borde de ningún tipo alrededor del contenido de nuestro sitio web; (ii)
              Puede enlazarse con <strong>SOLID PROJECT SOLUTIONS CORP</strong>. pero no puede
              constituir una réplica de este ni de sus contenidos; (iii) No debe implicar que SOLID
              PROJECT SOLUTIONS CORP. lo aprueba o patrocina, ni a ninguno de sus
              productos; (iv) No debe representar falsa información sobre <strong>SOLID PROJECT SOLUTIONS CORP</strong>,
              sus productos y/o sus servicios; (v) No debe utilizar el nombre
              ICS, o www.internationalcargosystem.com sin previo permiso por escrito de
              <strong>SOLID PROJECT SOLUTIONS CORP</strong>.; (vi) No debe presentar contenido que
              pueda
              resultar
              desagradable,
              ofensivo
              o
              controversial.
          </p>
          <p class="icstextterms">
            <strong>6.3.</strong>  6.3. No obstante cualquier disposición contraria al contenido de este Acuerdo,
              <strong>SOLID PROJECT SOLUTIONS CORP</strong> se reserva el derecho a denegar el permiso
              para mostrar un hipervínculo a nuestros sitios web por cualquier razón bajo nuestra
              única y absoluta discreción.
          </p>
          <p class="icstextterms">
            <strong>6.3.</strong> No obstante cualquier disposición contraria al contenido de este Acuerdo,
              <strong>SOLID PROJECT SOLUTIONS CORP</strong> se reserva el derecho a denegar el permiso
              para mostrar un hipervínculo a nuestros sitios web por cualquier razón bajo nuestra
              única y absoluta discreción.
          </p>
          <p class="icstextterms">
            <strong>6.4.</strong>  <strong>ICS</strong> genera un hipervínculo de un subdominio de su website
              www,internationalcargosystem.com que redirecciona los servicios hacia el sitio web
              de la empresa que usted representa y funciona como un enlace necesario entre el
              sitio web de la misma y los servicios web de <strong>ICS</strong>, sin que esto signifique una
              inclusión de los servicios, contenidos, productos y conceptos de <strong>ICS</strong> en el sitio web
              de la empresa que usted representa, y sin que signifique que los contenidos,
              productos, servicios y conceptos de la empresa que usted representa sean
              insertados o incluidos en el sitio web de <strong>ICS</strong>. En este sentido, a la empresa que
              usted representa se le generará y asignará un hipervínculo exclusivo identificado
              con la misma a la que solo usted tendrá acceso y control, ejemplo:
              www.tuempresa.internationalcargosystem.com.
          </p>
        </div>
        <!--7-->
        <div class="">
          <p class="icstextterms">
            <strong>7.</strong> Política de Registro. Para acceder a determinadas partes del sitio web es
            necesario Registrarse. Para registrarse, usted debe suministrar, entre otras cosas,
            una dirección valida de correo electrónico y una contraseña de 6 caracteres o más
            (Información de Registro), así mismo debe llenar un formulario con la información
            de la empresa que usted representa, aceptando y asegurando que dicha
            información es veraz y confiable. Una vez que usted se ha registrado, usted tendrá
            acceso a una cuenta única (su cuenta personal) a través de la cual usted puede
            acceder a varias características del sitio web. Es su responsabilidad mantener en
            secreto su información de registro. Usted debe estar de acuerdo con notificar a
            <strong>SOLID PROJECT SOLUTIONS CORP</strong> si usted cree que su información de registro
            esta,
          </p>
          <p class="icstextterms">
            <strong>7.1.</strong> Su registro en el sitio web no implica ningún deber de <strong>SOLID PROJECT SOLUTIONS CORP</strong>
              de
              proveerle
              algún
              servicio
              en
              particular
          </p>
          <p class="icstextterms">
            <strong>7.2. SOLID PROJECT SOLUTIONS CORP. </strong> se reserva el derecho a eliminar sucuenta por cualquier razón bajo su única y absoluta discreción en cualquier
              momento, sin enviarle previo aviso a usted.
          </p>
          <p class="icstextterms">
            <strong>7.3. SOLID PROJECT SOLUTIONS CORP. </strong> asegura que la información
              suministrada por usted en nuestro sitio web es confidencial y solo para uso
              administrativo de los servicios de ICS, por lo que dicha información está
              resguardada y no será ni revelada, ni publicada, ni distribuida, y en ningún caso,
              usada para otros fines diferentes a los establecidos y pactados.
          </p>
        </div>
        <!--8-->
        <div class="">
          <p class="icstextterms">
            <strong>8. Aviso específico sobre los softwares disponibles en el sitio web.</strong>
          </p>
          <p class="icstextterms">
            <strong>8.1</strong> Cualquier software disponible para descargar desde los sitios web o servidores
            de <strong>SOLID PROJECT SOLUTIONS CORP</strong> es un trabajo de <strong>SOLID PROJECT SOLUTIONS CORP</strong> registrado bajo derechos de autor.
          </p>
          <p class="icstextterms">
            <strong>8.2.</strong> El software está disponible para descargar únicamente para uso de los clientes
            finales. Se prohíbe expresamente por ley, cualquier reproducción o redistribución
            del software, la violación de esta disposición puede resultar en severas sanciones
            civiles y/o penales.
          </p>
          <p class="icstextterms">
            <strong>8.3.</strong> SIN PERJUICIO DE LO ANTERIOR, LA COPIA O REPRODUCCIÓN DEL
              SOFTWARE EN CUALQUIER OTRO SERVIDOR O UBICACIÓN PARA SU
              FUTURA REPRODUCCIÓN O REDISTRIBUCIÓN QUEDA EXPRESAMENTE
              PROHIBIDA, A MENOS QUE DICHA REPRODUCCIÓN O REDISTRIBUCIÓN
              ESTÉ EXPRESAMENTE PERMITIDA POR SOLID PROJECT SOLUTIONS CORP.
          </p>
        </div>
        <!--9-->
        <div class="">
          <p class="icstextterms">
            <strong>9. Contenido del Sitio e información; Características.</strong>
          </p>
          <p class="icstextterms">
            <strong>9.1.</strong> Los Sitios Web contienen información, asesoramiento, texto y otros materiales
            (en general, la Información) que se proporcionan para su comodidad y disfrute.
            Debe tener en cuenta que la información puede contener errores, omisiones,
            inexactitudes o información obsoleta. <strong>SOLID PROJECT SOLUTIONS CORP</strong> No
            hace representaciones o garantías en cuanto a la integridad, exactitud, suficiencia,
            actualidad o fiabilidad de la información y no será responsable de cualquier falta de
            los
          </p>
          <p class="icstextterms">
            <strong>9.2.</strong> Las descripciones o referencias a, productos o publicaciones dentro de los sitios
              web no implican su reconocimiento de ese producto o publicación.
          </p>
        </div>
        <!--10-->
        <div class="">
          <p class="icstextterms">
            <strong>10. Garantía</strong>
          </p>
          <p class="icstextterms">
            <strong>10.1.</strong> LOS SITIOS WEB, INCLUYENDO TODO EL CONTENIDO, SOFTWARE,
            FUNCIONES, MATERIALES E INFORMACIÓN PUESTOS A DISPOSICIÓN O
            ACCESIBLES O ENVIADOS DESDE LOS SITIOS WEB, se proporciona TAL CUAL.
            EN TODA LA EXTENSIÓN PERMITIDA POR LA LEY, <strong>SOLID PROJECT SOLUTIONS CORP</strong> Y SUS SUBSIDIARIAS Y AFILIADAS NO REPRESENTAN O
            DAN
            GARANTIA
            DE
            NINGÚN
            TIPO
            SOBRE:
          </p>
          <p class="icstextterms">
            <strong>10.1.1.</strong> EL CONTENIDO DE LOS SITIOS WEB;
          </p>
          <p class="icstextterms">
            <strong>10.1.2.</strong> LOS MATERIALES, INFORMACIÓN Y FUNCIONES ACCESIBLES A
              TRAVÉS DEL SOFTWARE UTILIZADO O ACCESIBLES A TRAVÉS DE LOS
              SITIOS
              WEB;
          </p>
          <p class="icstextterms">
            <strong>10.1.3.</strong> Los materiales, mensajes y la información enviada por los usuarios a LOS SITIOS
          </p>
          <p class="icstextterms">
            <strong>10.1.4.</strong> LOS PRODUCTOS O SERVICIOS O ENLACES DE HIPERTEXTO A TERCEROS;
          </p>
          <p class="icstextterms">
            <strong>10.1.5.</strong> INCUMPLIMIENTO DE LA SEGURIDAD ASOCIADA A LA TRANSMISIÓN
            DE INFORMACIÓN SENSIBLE A TRAVÉS DE LOS SITIOS WEB O CUALQUIER
            SITIO
          </p>
          <p class="icstextterms">
            <strong>10.2.</strong> ADEMÁS, <strong>SOLID PROJECT SOLUTIONS CORP</strong>. Y SUS SUBSIDIARIAS Y
              FILIALES NO OTORGAN NINGUNA GARANTÍA EXPRESA O IMPLÍCITA
              INCLUYENDO, SIN LIMITACIONES, NO INFRACCIÓN, COMERCIALIZACIÓN Y
              APTITUD PARA UN PROPÓSITO PARTICULAR. SOLID PROJECT SOLUTIONS
              CORP NO GARANTIZA QUE LAS FUNCIONES CONTENIDAS EN LOS SITIOS
              WEB O CUALQUIER MATERIAL O CONTENIDO DEL MISMO será ininterrumpido
              o libre de errores; Que los defectos serán corregidos; O QUE LOS SITIOS WEB O
              LOS SERVIDORES QUE LOS HACE DISPONIBLES ESTÁN LIBRES DE VIRUS U
              OTROS COMPONENTES PERJUDICIALES. <strong>SOLID PROJECT SOLUTIONS CORP</strong>.
              Y SUS SUBSIDIARIAS Y AFILIADOS NO SERÁN RESPONSABLES POR
              EL USO DE LOS SITIOS WEB, INCLUYENDO, SIN LIMITACIÓN, EL CONTENIDO
              Y CUALQUIER ERROR QUE PUEDA FIGURAR EN ELLOS. ALGUNAS
              JURISDICCIONES LIMITAN O NO PERMITEN LA EXCLUSIÓN IMPLÍCITA U
              OTRAS DE GARANTÍAS DE MODO QUE LA RENUNCIA ANTERIOR PUEDE QUE
              NO APLIQUE A USTED A LOS EFECTOS DE LAS LEYES DE DICHA
              JURISDICCIÓN
              APLICABLES
              A
              ESTE
              ACUERDO.
          </p>
          <p class="icstextterms">
            <strong>10.3. SOLID PROJECT SOLUTIONS CORP</strong>. NO GARANTIZA QUE SUS
              ACTIVIDADES O USO DE LOS SITIOS WEB SON LEGALES EN NINGUNA
              JURISDICCIÓN EN PARTICULAR Y, en cualquier caso, RECHAZAN
              ESPECÍFICAMENTE LAS GARANTÍAS. USTED ENTIENDE QUE AL UTILIZAR
              ALGUNA DE LAS CARACTERÍSTICAS DE LOS SITIOS WEB, ACTÚA BAJO SU
              PROPIA RESPONSABILIDAD, Y USTED REPRESENTA Y GARANTIZA QUE SUS
              ACTIVIDADES SON LEGALES EN CADA JURISDICCIÓN DONDE USTED accede
              o
              utiliza
              los
              sitios
              web.
          </p>
        </div>
        <!--11-->
        <div class="">
          <p class="icstextterms">
            <strong>11. Limitación de responsabilidad; Indemnización.</strong>
          </p>
          <p class="icstextterms">
            <strong>11.1.</strong> En ningún caso <strong>SOLID PROJECT SOLUTIONS CORP</strong>. será responsable de
            cualquier daño especial, indirecto o consecuente que esté directa o indirectamente
            relacionado con el uso o la imposibilidad de usar los Sitios Web, incluso si <strong>SOLID PROJECT SOLUTIONS CORP</strong>.
             ha sido advertido de la posibilidad de dichos daños.
            Algunos estados no permiten la exclusión o limitación de daños incidentales o
            consecuentes, por lo que la limitación o exclusión anterior puede no aplicarse en su
            caso. En ningún caso que <strong>SOLID PROJECT SOLUTIONS CORP</strong>. tenga la
            responsabilidad total en concepto de daños, pérdidas o causas de acción, la
            indemnización
            excederá
            los
            cien
            dólares
            ($100).
          </p>
          <p class="icstextterms">
            <strong>11.2.</strong> Usted se compromete a defender e indemnizar <strong>SOLID PROJECT SOLUTIONS CORP</strong>.,
            sus funcionarios, empleados, representantes propietarios yagentes de cualquier reclamación, demanda, sanciones, multas, responsabilidades,
            abogados honorarios, costos judiciales, gastos legales y causas de acción de
            cualquier naturaleza, ya sea civil o penal, por las pérdidas y / o daños de cualquier
            tipo que puedan interponerse contra SOLID PROJECT SOLUTIONS CORP. y / o
            indemnizaciones, de cualquier forma, directa o indirectamente, incidente,
            consecuencia del trabajo, en relación con los Sitios Web o como resultado de su
            uso.
          </p>
        </div>
        <!--12-->
        <div class="">
          <p class="icstextterms">
            <strong>12. Ley aplicable. </strong> El presente Acuerdo y la interpretación de sus términos se regirán
            e interpretarán de conformidad con las leyes de Panamá, sin tener en cuenta sus
            conflictos
          </p>
        </div>
        <!--13-->
        <div class="">
          <p class="icstextterms">
            <strong>13. Jurisdicción y Competencia. </strong> Las partes se someten irrevocablemente y
              consienten a la jurisdicción y competencia exclusiva de los tribunales de Ciudad de
              Panamá, Panamá y sus jurisdicciones y fueros. Las partes renuncian a cualquier
              derecho a juicio por jurado en cualquier acción o procedimiento iniciado en relación
              con el presente Acuerdo
          </p>
        </div>
        <!--14-->
        <div class="">
          <p class="icstextterms">
            <strong>13. Notificaciones. </strong>
          </p>
          <p class="icstextterms">
            <strong>14.1. </strong>  Cuando deba o se le permita a <strong>SOLID PROJECT SOLUTIONS CORP</strong>.,
            conforme a las disposiciones del presente Acuerdo, enviarle una notificación a
            usted, <strong>SOLID PROJECT SOLUTIONS CORP</strong>. Enviará un correo electrónico a la
            dirección proporcionada por usted al registrarse en los sitios web. Si usted no ha
            proporcionado una dirección de correo electrónico o si no está registrado con los
            sitios web, <strong>SOLID PROJECT SOLUTIONS CORP</strong>. le enviará un aviso de alguna
            manera
          </p>
        </div>
        <!--15-->
        <div class="">
          <p class="icstextterms">
            <strong>15. </strong> Misceláneas. Este Acuerdo contiene el único y total acuerdo entre las partes con
              respecto al uso de los Sitios Web y reemplaza todos los demás acuerdos anteriores
              escritos o verbales. Los títulos contenidos en este Acuerdo se incluyen sólo como
              un asunto de conveniencia y de ninguna manera definen, limitan, extienden, o
              describen el ámbito del presente Acuerdo o la intención de cualquier disposición de
              este Acuerdo. Las partes renuncian a cualquier derecho a juicio por jurado en
              cualquier acción o procedimiento iniciado en relación con el presente Acuerdo.
              Cualquier controversia o reclamo que surja a partir de este este Acuerdo o
              relacionados con él, o el incumplimiento de este Acuerdo, serán resueltas por
              arbitraje administrado por los Tribunales del Estado de Panamá en el ejercicio
              pertinente de sus jurisdicciones y fueros de acuerdo con sus reglas de arbitraje
              comercial. Si alguna disposición de este Acuerdo se considera inválida o inaplicable
              por cualquier tribunal de jurisdicción competente o como resultado de una futura
              acción legislativa, dicha consideración o acción será interpretada estrictamente y no
              afectarán a la validez o efecto de cualquier otra disposición de este Acuerdo .
              Última actualización: Abril, 2017
          </p>
        </div>
        <!--Img-->
        <div class="">
          <h1 style="text-align:right">
            <img style=" width: 5%" src="{{asset('dist/img/favicon.png')}}" alt="" />
          </h1>
        </div>
      </div>
    </div>
  </div>
</section>
@stop
