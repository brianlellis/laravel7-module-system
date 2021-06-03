@php
  if (auth()->user()->hasrole('Agent')) {
    $tour_check           = \Rapyd\Tours::first_visit();
    $incomplete_usergroup = auth()->user()->usergroup()->where('producer_agreement_ip', null)->first();
  } elseif (auth()->user()->hasanyrole('Underwriter|Developer')) {
    $start_date           = request()->get('start_date');
    $transactions         = \PolicyReports::get_issued_info($start_date);
  }
@endphp

@if (auth()->user()->hasrole('Agent'))
  @if(!auth()->user()->agency())
    <div class="container mx-auto">
      <div class="card">
        <div class="card-header">
          Welcome, {{ auth()->user()->name_first }} {{ auth()->user()->name_last }}
        </div>
        <div class="card-body">
          <p>
            You are not currently attached to an agency. Please contact website administrator.
          </p>
        </div>
      </div>
    </div>
  @else
    @if($incomplete_usergroup)
      @php
        Session::flash('incomplete_usergroup', $incomplete_usergroup);
      @endphp
      @include($fallback, ['blade_lookup' => 'dashboard_assets.components.usergroup.usergroup-completion'])
    @else
      <div class="panel panel-default agent">
        <div class="card">
          <div class="card-header">
            <h1>Welcome, {{ auth()->user()->name_first }}</h1>
            <h2>What would you like to do today?</h2>
            <br />
          </div>
          <div class="card-body">

            {{-- New Quote --}}
            <a href="/bondquote" class="card text-success" id="new_bond_quote">
              <p>New Quote</p>
              <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas"
                data-icon="file-invoice-dollar" class="svg-inline--fa fa-file-invoice-dollar fa-w-12" role="img"
                viewBox="0 0 384 512">
                <path fill="currentColor"
                  d="M377 105L279.1 7c-4.5-4.5-10.6-7-17-7H256v128h128v-6.1c0-6.3-2.5-12.4-7-16.9zm-153 31V0H24C10.7 0 0 10.7 0 24v464c0 13.3 10.7 24 24 24h336c13.3 0 24-10.7 24-24V160H248c-13.2 0-24-10.8-24-24zM64 72c0-4.42 3.58-8 8-8h80c4.42 0 8 3.58 8 8v16c0 4.42-3.58 8-8 8H72c-4.42 0-8-3.58-8-8V72zm0 80v-16c0-4.42 3.58-8 8-8h80c4.42 0 8 3.58 8 8v16c0 4.42-3.58 8-8 8H72c-4.42 0-8-3.58-8-8zm144 263.88V440c0 4.42-3.58 8-8 8h-16c-4.42 0-8-3.58-8-8v-24.29c-11.29-.58-22.27-4.52-31.37-11.35-3.9-2.93-4.1-8.77-.57-12.14l11.75-11.21c2.77-2.64 6.89-2.76 10.13-.73 3.87 2.42 8.26 3.72 12.82 3.72h28.11c6.5 0 11.8-5.92 11.8-13.19 0-5.95-3.61-11.19-8.77-12.73l-45-13.5c-18.59-5.58-31.58-23.42-31.58-43.39 0-24.52 19.05-44.44 42.67-45.07V232c0-4.42 3.58-8 8-8h16c4.42 0 8 3.58 8 8v24.29c11.29.58 22.27 4.51 31.37 11.35 3.9 2.93 4.1 8.77.57 12.14l-11.75 11.21c-2.77 2.64-6.89 2.76-10.13.73-3.87-2.43-8.26-3.72-12.82-3.72h-28.11c-6.5 0-11.8 5.92-11.8 13.19 0 5.95 3.61 11.19 8.77 12.73l45 13.5c18.59 5.58 31.58 23.42 31.58 43.39 0 24.53-19.05 44.44-42.67 45.07z" />
              </svg>
            </a>
            {{-- Quote / Bond History --}}
            <a href="/admin/usergroups/profile?group={{auth()->user()->usergroup()->first()->id}}&tab=Policies" class="card" id="bond_quote_history">
              <p>Agency Policy <br> History</p>
              <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas"
                data-icon="history" class="svg-inline--fa fa-history fa-w-16" role="img" viewBox="0 0 512 512">
                <path fill="currentColor"
                  d="M504 255.531c.253 136.64-111.18 248.372-247.82 248.468-59.015.042-113.223-20.53-155.822-54.911-11.077-8.94-11.905-25.541-1.839-35.607l11.267-11.267c8.609-8.609 22.353-9.551 31.891-1.984C173.062 425.135 212.781 440 256 440c101.705 0 184-82.311 184-184 0-101.705-82.311-184-184-184-48.814 0-93.149 18.969-126.068 49.932l50.754 50.754c10.08 10.08 2.941 27.314-11.313 27.314H24c-8.837 0-16-7.163-16-16V38.627c0-14.254 17.234-21.393 27.314-11.314l49.372 49.372C129.209 34.136 189.552 8 256 8c136.81 0 247.747 110.78 248 247.531zm-180.912 78.784l9.823-12.63c8.138-10.463 6.253-25.542-4.21-33.679L288 256.349V152c0-13.255-10.745-24-24-24h-16c-13.255 0-24 10.745-24 24v135.651l65.409 50.874c10.463 8.137 25.541 6.253 33.679-4.21z" />
              </svg>
            </a>
            {{-- Profile --}}
            <a href="/admin/user/profile" class="card text-info" id="goto_agent_profile">
              <p>Edit Your <br> Profile</p>
              <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas"
                data-icon="id-card" class="svg-inline--fa fa-id-card fa-w-18" role="img" viewBox="0 0 576 512">
                <path fill="currentColor"
                  d="M528 32H48C21.5 32 0 53.5 0 80v16h576V80c0-26.5-21.5-48-48-48zM0 432c0 26.5 21.5 48 48 48h480c26.5 0 48-21.5 48-48V128H0v304zm352-232c0-4.4 3.6-8 8-8h144c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H360c-4.4 0-8-3.6-8-8v-16zm0 64c0-4.4 3.6-8 8-8h144c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H360c-4.4 0-8-3.6-8-8v-16zm0 64c0-4.4 3.6-8 8-8h144c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H360c-4.4 0-8-3.6-8-8v-16zM176 192c35.3 0 64 28.7 64 64s-28.7 64-64 64-64-28.7-64-64 28.7-64 64-64zM67.1 396.2C75.5 370.5 99.6 352 128 352h8.2c12.3 5.1 25.7 8 39.8 8s27.6-2.9 39.8-8h8.2c28.4 0 52.5 18.5 60.9 44.2 3.2 9.9-5.2 19.8-15.6 19.8H82.7c-10.4 0-18.8-10-15.6-19.8z" />
              </svg>
            </a>

          </div>
        </div>
      </div>
      <script>
        var tour = [
            {
                element: '#navbar_right_dropdown',
                title: 'Welcome to BondExchange',
                description: `To make your user experience as seamless as possible we have put together a quick site tour. At any time you can exit these tours while still having access to them if ever you need some help.
                  <br><br>
                  To navigate the tour you can use your keyboard arrow keys or click the arrows on your screen.`
            },
            {
                element: '#dropdown_menu_wrapper',
                title: 'Navigaton Items',
                description: `
                  <ol>
                    <li>
                      Profile - You can access your agent profile via this link
                    </li>
                    <li>
                      My Agency - Allows you access to your assigned agency's profile
                    </li>
                    <li>
                      Admin Dashboard - Brings you back to the main dashboard page
                    </li>
                    <li>
                      Admin Dashboard - Takes you to the public homepage of the website
                    </li>
                    <li>
                      See Page Guide - Accesses the current page's guided help tour
                    </li>
                  </ol>
                `
            },
            {
                element: '#new_bond_quote',
                title: 'Start a new bond quote',
                description: 'This button will take you to the BX Bondquote Stepper system to get you started on a new bond quote for your customer.',
            },
            {
                element: '#bond_quote_history',
                title: 'Review Policy History',
                description: "This button will take you to your Agency's policy history dashboard, allowing you to review all policies and quotes created in the system.",
            },
            {
                element: '#goto_agent_profile',
                title: 'Agent Profile Dashboard',
                description: "Need to review and/or edit your agent information? Click here to review your agent information in the system, along with having access to your Agency's profile information also.",
            },
            {
                title: 'Continue Tour?',
                description: `
                  <p>
                    You can continue to tour or stop now. Remember, you can always get help from the dropdown menu if information is needed in the future.
                  </p>
                  <button class="btn btn-success" onclick="(function(){ window.location.href = '/admin/user/profile';})();">Continue Tour</button>
                  <button class="btn btn-danger" onclick="(function(){ $('.gc-close').click();})();">End Tour</button>
                `,
            }
        ];

        GuideChimp.extend(guideChimpPluginPlaceholders, { template: '%*%' });
        var guideChimp = GuideChimp(tour);

        // CALLBACK ACTIONS FOR SPECIFIC STEPS OF TOUR
        guideChimp.on('onAfterChange', (to, from)=>{
          if(to.title == 'Navigaton Items') {
            setTimeout(() => {
              $('#navbar_right_dropdown > div > a').click();
            }, 0); // RACE CONDITION ISSUE
          }
        });

        // START GUIDED TOUR
        @if($tour_check) guideChimp.start(); @endif
      </script>
    @endif
  @endif
@elseif (auth()->user()->hasanyrole('Underwriter|Developer'))
  {{-- FIX GREP MEMORY RESOURCE EXHUASTION --}}
  <div class="row">
    <div id="summary_policy_blocks" class="col-12">
      <h3>Today Totals</h3>
      <div class="row">
        <div class="col-lg-4 col-sm-12">
          <div class="card">
            <div class="card-body text-center statistics-info">
              <h6>Policies Issued</h6>
              <h4 class="number-font">{{$transactions['day_1']['invoices']['count']}}</h4>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-12">
          <div class="card">
            <div class="card-body text-center statistics-info">
              <h6>Total Cost of Policies</h6>
              <h4 class="number-font">{{$transactions['day_1']['invoices']['total_cost_sum']['string']}}</h4>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-12">
          <div class="card">
            <div class="card-body text-center statistics-info">
              <h6>Agent Commissions</h6>
              <h4 class="number-font">{{$transactions['day_1']['invoices']['agent_commissions']['string']}}</h4>
            </div>
          </div>
        </div>
      </div>

      <h3>Past 7 Days Totals</h3>
      <div class="row">
        <div class="col-lg-4 col-sm-12">
          <div class="card">
            <div class="card-body text-center statistics-info">
              <h6>Policies Issued</h6>
              <h4 class=" number-font">{{$transactions['total']['count']}}</h4>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-12">
          <div class="card">
            <div class="card-body text-center statistics-info">
              <h6>Total Cost of Policies</h6>
              <h4 class="number-font">{{$transactions['total']['total_cost_sum']['string']}}</h4>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-12">
          <div class="card">
            <div class="card-body text-center statistics-info">
              <h6>Agent Commissions</h6>
              <h4 class="number-font">{{$transactions['total']['agent_commissions']['string']}}</h4>
            </div>
          </div>
        </div>
      </div>

      <h3>Projection Monthly Totals</h3>
      <div class="row">
        <div class="col-lg-4 col-sm-12">
          <div class="card">
            <div class="card-body text-center statistics-info">
              <h6>Policies Issued</h6>
              <h4 class=" number-font">{{$transactions['projections']['count']}}</h4>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-12">
          <div class="card">
            <div class="card-body text-center statistics-info">
              <h6>Total Cost of Policies</h6>
              <h4 class="number-font">{{$transactions['projections']['total_cost_sum']['string']}}</h4>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-12">
          <div class="card">
            <div class="card-body text-center statistics-info">
              <h6>Agent Commissions</h6>
              <h4 class="number-font">{{$transactions['projections']['agent_commissions']['string']}}</h4>
            </div>
          </div>
        </div>
      </div>
    </div>

    <canvas id="bar-chart" width="800" height="300" class="mb-6"></canvas>

    <script>
      // Bar chart
      new Chart(document.getElementById("bar-chart"), {
          type: 'bar',
          data: {
            labels: [
              "{{$transactions['day_7']['date']}}",
              "{{$transactions['day_6']['date']}}",
              "{{$transactions['day_5']['date']}}",
              "{{$transactions['day_4']['date']}}",
              "{{$transactions['day_3']['date']}}",
              "{{$transactions['day_2']['date']}}",
              "{{$transactions['day_1']['date']}}"
            ],
            datasets: [
              {
                label: "Policy Issuances",
                backgroundColor: ["#09ad95","#09ad95","#09ad95","#09ad95","#09ad95","#09ad95","#09ad95"],
                data: [
                  {{$transactions['day_7']['invoices']['count']}},
                  {{$transactions['day_6']['invoices']['count']}},
                  {{$transactions['day_5']['invoices']['count']}},
                  {{$transactions['day_4']['invoices']['count']}},
                  {{$transactions['day_3']['invoices']['count']}},
                  {{$transactions['day_2']['invoices']['count']}},
                  {{$transactions['day_1']['invoices']['count']}}
                ]
              }
            ]
          },
          options: {
            legend: { display: false },
            title: {
              display: true,
              text: 'Policy Issuances (Past 7 Days)'
            },
            scales: {
              yAxes: [{
                display: true,
                ticks: {
                  beginAtZero: true,
                  max: {{$transactions['total']['count'] / 3}}
                }
              }]
            },
            tooltips: {
              callbacks: {
                label: function(t, d) {
                  var yLabel = t.yLabel >= 1000 ? t.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : t.yLabel;
                  return yLabel;
                }
              }
            }
          }
      });
    </script>
  </div>

  <div class="row">
    <div class="col-1">
      Select Start Date:
    </div>
    <div class="col-3">
      <input
        class="form-control"
        placeholder="MM/DD/YYYY"
        type="text"
        id="policy_report_start_date"
        @if($start_date)
          value="{{str_replace('-', '/', $start_date)}}"
        @endif
      >
    </div>

    <div class="col-6">
      <button class="btn btn-primary mb-6" onclick="view_report_date_range()">
        View Past 7 Days
      </button>

      <script>
        $('#policy_report_start_date').daterangepicker({
          singleDatePicker: true
        }, function(start, end, label) {
          var dateval = start.format('YYYY-MM-DD');
          $('#policy_report_start_date').val(dateval);
        });

        function view_report_date_range() {
          var start_date = document.getElementById('policy_report_start_date')
                            .value.replace(/\//g,'-');

          window.location.href = '/admin/dashboard?start_date='+start_date;
        }
      </script>
    </div>
  </div>
@endif
