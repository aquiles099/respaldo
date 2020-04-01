<div class="row" style="min-height: 781px">
  <div class="col-md-12">
    <section class="gray icssectionadmin" style="margin-top: 40px !important">
      <div class="row" style="margin-left: -10px">
        @if(!isset($only))
        <div class="col-md-3">
            @include('sections.side-menu')
        </div>
        <div class="col-md-9">
          <div class="row" >
            <div class="col-md-11">
              <div class="page-header">
                <h1>
                  <span>
                    <a class="btn btn-danger" onclick="icsAutoBack()">
                      <i class="fa fa-chevron-left" aria-hidden="true"></i>
                      {{trans('messages.back')}}
                    </a>
                  </span>
                  <span>@yield('admin-page-title', trans('ICS'))</span>
                  <span class="small" id="icsLoadExternal"></span>
                  <span class="pull-right">@yield('admin-actions')</span>
                </h1>
              </div>
         @endif
               @yield('admin-body')
         @if(!isset($only))
            </div>
          </div>
        </div>
        @endif
      </div>
    </section>
  </div>
</div>
