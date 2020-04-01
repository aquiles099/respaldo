<div style="padding: 27px; background-color: #f2f2f2">
  <div style="padding: 20px; background-color: #ffffff">
    <div style="padding-top: 20px; padding-bottom: 20px">
    <table>
      <tr>
        <td>
          <img src="{{asset('dist/img/logo.png')}}" style="height: 45px">
        </td>
        <td>
        </td>
      </tr>
    </table>
    </div>
      @yield('mail-body')
      <div style="margin-bottom: 50px;">
      </div>
      <div style="padding-top: 7px; padding-bottom: 7px; background-color: #2E5179">
        <div class="">
          <table style="width:100%">
            <tr>
              <td style="float: left; margin-left: 5px">
                <a href="{{env('ICS_FACEBOOK_URL')}}" target="_blank" data-toggle="tooltip" data-placement="top">
                  <img src="{{asset('dist/img/icon/FB.png')}}" alt="{{trans('messages.ICS')}} - {{trans('messages.slogan')}}" style=" width: 30px"/>
                </a>
              </td>
              <td style="float: left; margin-left: 5px">
                <a href="{{env('ICS_TWITTER_URL')}}" target="_blank" data-toggle="tooltip" data-placement="top">
                  <img src="{{asset('dist/img/icon/TW.png')}}" alt="{{trans('messages.ICS')}} - {{trans('messages.slogan')}}" style=" width: 30px"/>
                </a>
              </td>
              <td style="float: left; margin-left: 5px">
                <a href="{{env('ICS_INSTAGRAM_URL')}}" target="_blank" data-toggle="tooltip" data-placement="top">
                  <img src="{{asset('dist/img/icon/IG.png')}}" alt="{{trans('messages.ICS')}} - {{trans('messages.slogan')}}" style=" width: 30px"/>
                </a>
              </td>
              <td style="text-align: right; padding-right: 12px; font-weight: bold; color: white;">
                Copyright©2017 WEB-ICS
              </td>
            </tr>
          </table>
       </div>
    </div>
  </div>
</div>
