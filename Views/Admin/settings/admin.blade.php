@can('sys-admin-admin-settings')
  <div class="panel panel-primary">
      <div class="tab_wrapper first_tab">
          <ul class="tab_list">
              <li class="active" rel="tab_1_1">Colors</li>
              <li rel="tab_1_2">Notifications</li>
          </ul>

          <div class="content_wrapper">
              {{-- COLOR PICKING SYSTEM --}}
              <div class="tab_content active first tab_1_1" title="tab_1_1" style="display: block;">
                  <form action="{{route('rapyd.settings.admin.colors')}}" method="POST" class="row">
                      @csrf

                      <div class="col-lg-12">
                          <div class="card">
                              <div class="card-header">
                                  <h3 class="card-title">Branding Color Guide</h3>
                              </div>
                              <div class="card-body">
                                  <div class="text-wrap">
                                      <div class="example">
                                          <div class="row">
                                              {{-- PRIMARY COLOR --}}
                                              <div class="col-md-6 col-lg-4 col-sm-6">
                                                  <div class="d-flex align-items-center mb-3 mt-3">
                                                      <input class="w-7 h-7 mr-4" name="colorPrimary" id="colorPrimary" type="text">
                                                      <input name="colorPrimaryOriginal" id="colorPrimaryOriginal" type="hidden">
                                                      <code class="colorpick_code bg-primary">.bg-primary</code>
                                                  </div>
                                              </div>

                                              {{-- INFO COLOR --}}
                                              <div class="col-md-6 col-lg-4 col-sm-6">
                                                  <div class="d-flex align-items-center mb-3 mt-3">
                                                      <input class="w-7 h-7 mr-4" name="colorInfo" id="colorInfo" type="text">
                                                      <input name="colorInfoOriginal" id="colorInfoOriginal" type="hidden">
                                                      <code class="colorpick_code bg-info">.bg-info</code>
                                                  </div>
                                              </div>

                                              {{-- SECONDARY COLOR --}}
                                              <div class="col-md-6 col-lg-4 col-sm-6">
                                                  <div class="d-flex align-items-center mb-3 mt-3">
                                                      <input class="w-7 h-7 mr-4" name="colorSecondary" id="colorSecondary" type="text">
                                                      <input name="colorSecondaryOriginal" id="colorSecondaryOriginal" type="hidden">
                                                      <code class="colorpick_code bg-secondary">.bg-secondary</code>
                                                  </div>
                                              </div>

                                              {{-- WARNING COLOR --}}
                                              <div class="col-md-6 col-lg-4 col-sm-6">
                                                  <div class="d-flex align-items-center mb-3 mt-3">
                                                      <input class="w-7 h-7 mr-4" name="colorWarning" id="colorWarning" type="text">
                                                      <input name="colorWarningOriginal" id="colorWarningOriginal" type="hidden">
                                                      <code class="colorpick_code bg-warning">.bg-warning</code>
                                                  </div>
                                              </div>

                                              {{-- DANGER COLOR --}}
                                              <div class="col-md-6 col-lg-4 col-sm-6">
                                                  <div class="d-flex align-items-center mb-3 mt-3">
                                                      <input class="w-7 h-7 mr-4" name="colorDanger" id="colorDanger" type="text">
                                                      <input name="colorDangerOriginal" id="colorDangerOriginal" type="hidden">
                                                      <code class="colorpick_code bg-danger">.bg-danger</code>
                                                  </div>
                                              </div>

                                              {{-- SUCCESS COLOR --}}
                                              <div class="col-md-6 col-lg-4 col-sm-6">
                                                  <div class="d-flex align-items-center mb-3 mt-3">
                                                      <input class="w-7 h-7 mr-4" name="colorSuccess" id="colorSuccess" type="text">
                                                      <input name="colorSuccessOriginal" id="colorSuccessOriginal" type="hidden">
                                                      <code class="colorpick_code bg-success">.bg-success</code>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>

                      {{-- OTHER BASIC COLORS --}}
                      <div class="col-lg-12">
                          <div class="card">
                              <div class="card-header">
                                  <h3 class="card-title">Other colors</h3>
                              </div>
                              <div class="card-body">
                                  <div class="text-wrap">
                                      <div class="example">
                                          <div class="row">
                                              {{-- PRIMARY COLOR --}}
                                              <div class="col-md-6 col-lg-4 col-sm-6">
                                                  <div class="d-flex align-items-center mb-3 mt-3">
                                                      <input class="colorpick_code w-7 h-7 mr-4" id="bgBlue" type="text">
                                                      <code class="bg-blue">.bg-blue</code>
                                                  </div>
                                              </div>

                                              {{-- INFO COLOR --}}
                                              <div class="col-md-6 col-lg-4 col-sm-6">
                                                  <div class="d-flex align-items-center mb-3 mt-3">
                                                      <input class="w-7 h-7 mr-4" name="bgAzure" id="bgAzure" type="text">
                                                      <input name="bgAzureOriginal" id="bgAzureOriginal" type="hidden">
                                                      <code class="colorpick_code bg-azure">.bg-azure</code>
                                                  </div>
                                              </div>

                                              {{-- SECONDARY COLOR --}}
                                              <div class="col-md-6 col-lg-4 col-sm-6">
                                                  <div class="d-flex align-items-center mb-3 mt-3">
                                                      <input class="w-7 h-7 mr-4" name="bgIndigo" id="bgIndigo" type="text">
                                                      <input name="bgIndigoOriginal" id="bgIndigoOriginal" type="hidden">
                                                      <code class="colorpick_code bg-indigo">.bg-indigo</code>
                                                  </div>
                                              </div>

                                              {{-- WARNING COLOR --}}
                                              <div class="col-md-6 col-lg-4 col-sm-6">
                                                  <div class="d-flex align-items-center mb-3 mt-3">
                                                      <input class="w-7 h-7 mr-4" name="bgPurple" id="bgPurple" type="text">
                                                      <input name="bgPurpleOriginal" id="bgPurpleOriginal" type="hidden">
                                                      <code class="colorpick_code bg-purple">.bg-purple</code>
                                                  </div>
                                              </div>

                                              {{-- DANGER COLOR --}}
                                              <div class="col-md-6 col-lg-4 col-sm-6">
                                                  <div class="d-flex align-items-center mb-3 mt-3">
                                                      <input class="w-7 h-7 mr-4" name="bgPink" id="bgPink" type="text">
                                                      <input name="bgPinkOriginal" id="bgPinkOriginal" type="hidden">
                                                      <code class="colorpick_code bg-pink">.bg-pink</code>
                                                  </div>
                                              </div>

                                              {{-- SUCCESS COLOR --}}
                                              <div class="col-md-6 col-lg-4 col-sm-6">
                                                  <div class="d-flex align-items-center mb-3 mt-3">
                                                      <input class="w-7 h-7 mr-4" name="bgRed" id="bgRed" type="text">
                                                      <input name="bgRedOriginal" id="bgRedOriginal" type="hidden">
                                                      <code class="colorpick_code bg-red">.bg-red</code>
                                                  </div>
                                              </div>

                                              {{-- INFO COLOR --}}
                                              <div class="col-md-6 col-lg-4 col-sm-6">
                                                  <div class="d-flex align-items-center mb-3 mt-3">
                                                      <input class="w-7 h-7 mr-4" name="bgOrange" id="bgOrange" type="text">
                                                      <input name="bgOrangeOriginal" id="bgOrangeOriginal" type="hidden">
                                                      <code class="colorpick_code bg-orange">.bg-orange</code>
                                                  </div>
                                              </div>

                                              {{-- SECONDARY COLOR --}}
                                              <div class="col-md-6 col-lg-4 col-sm-6">
                                                  <div class="d-flex align-items-center mb-3 mt-3">
                                                      <input class="w-7 h-7 mr-4" name="bgYellow" id="bgYellow" type="text">
                                                      <input name="bgYellowOriginal" id="bgYellowOriginal" type="hidden">
                                                      <code class="colorpick_code bg-yellow">.bg-yellow</code>
                                                  </div>
                                              </div>

                                              {{-- WARNING COLOR --}}
                                              <div class="col-md-6 col-lg-4 col-sm-6">
                                                  <div class="d-flex align-items-center mb-3 mt-3">
                                                      <input class="w-7 h-7 mr-4" name="bgLime" id="bgLime" type="text">
                                                      <input name="bgLimeOriginal" id="bgLimeOriginal" type="hidden">
                                                      <code class="colorpick_code bg-lime">.bg-lime</code>
                                                  </div>
                                              </div>

                                              {{-- DANGER COLOR --}}
                                              <div class="col-md-6 col-lg-4 col-sm-6">
                                                  <div class="d-flex align-items-center mb-3 mt-3">
                                                      <input class="w-7 h-7 mr-4" name="bgGreen" id="bgGreen" type="text">
                                                      <input name="bgGreenOriginal" id="bgGreenOriginal" type="hidden">
                                                      <code class="colorpick_code bg-green">.bg-green</code>
                                                  </div>
                                              </div>

                                              {{-- SUCCESS COLOR --}}
                                              <div class="col-md-6 col-lg-4 col-sm-6">
                                                  <div class="d-flex align-items-center mb-3 mt-3">
                                                      <input class="w-7 h-7 mr-4" name="bgTeal" id="bgTeal" type="text">
                                                      <input name="bgTealOriginal" id="bgTealOriginal" type="hidden">
                                                      <code class="colorpick_code bg-teal">.bg-teal</code>
                                                  </div>
                                              </div>

                                              {{-- INFO COLOR --}}
                                              <div class="col-md-6 col-lg-4 col-sm-6">
                                                  <div class="d-flex align-items-center mb-3 mt-3">
                                                      <input class="w-7 h-7 mr-4" name="bgCyan" id="bgCyan" type="text">
                                                      <input name="bgCyanOriginal" id="bgCyanOriginal" type="hidden">
                                                      <code class="colorpick_code bg-cyan">.bg-cyan</code>
                                                  </div>
                                              </div>

                                              {{-- SECONDARY COLOR --}}
                                              <div class="col-md-6 col-lg-4 col-sm-6">
                                                  <div class="d-flex align-items-center mb-3 mt-3">
                                                      <input class="w-7 h-7 mr-4" name="bgGray" id="bgGray" type="text">
                                                      <input name="bgGrayOriginal" id="bgGrayOriginal" type="hidden">
                                                      <code class="colorpick_code bg-gray">.bg-gray</code>
                                                  </div>
                                              </div>

                                              {{-- WARNING COLOR --}}
                                              <div class="col-md-6 col-lg-4 col-sm-6">
                                                  <div class="d-flex align-items-center mb-3 mt-3">
                                                      <input class="w-7 h-7 mr-4" name="bgGrayDark" id="bgGrayDark" type="text">
                                                      <input name="bgGrayDarkOriginal" id="bgGrayDarkOriginal" type="hidden">
                                                      <code class="colorpick_code bg-gray-dark">.bg-gray-dark</code>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <div class="col-sm-12">
                          <div class="card">
                              <div class="card-header">
                                  <h3 class="card-title">Button Presentation</h3>
                              </div>
                              <div class="card-body">
                                  <div class="btn-list">
                                      <a href="#" class="btn btn-primary">Primary</a>
                                      <a href="#" class="btn btn-secondary">Secondary</a>
                                      <a href="#" class="btn btn-success">Success</a>
                                      <a href="#" class="btn btn-info">Info</a>
                                      <a href="#" class="btn btn-warning">Warning</a>
                                      <a href="#" class="btn btn-danger">Danger</a>
                                  </div>
                              </div>

                              <div class="card-body">
                                  <div class="btn-list">
                                      <a href="#" class="btn btn-blue">Blue</a>
                                      <a href="#" class="btn btn-azure">Azure</a>
                                      <a href="#" class="btn btn-indigo">Indigo</a>
                                      <a href="#" class="btn btn-purple">Purple</a>
                                      <a href="#" class="btn btn-pink">Pink</a>

                                      <a href="#" class="btn btn-red">Red</a>
                                      <a href="#" class="btn btn-orange">Orange</a>
                                      <a href="#" class="btn btn-yellow">Yellow</a>
                                      <a href="#" class="btn btn-lime">Lime</a>
                                      <a href="#" class="btn btn-green">Green</a>

                                      <a href="#" class="btn btn-teal">Teal</a>
                                      <a href="#" class="btn btn-cyan">Cyan</a>
                                      <a href="#" class="btn btn-gray">Gray</a>
                                      <a href="#" class="btn btn-gray-dark">Gray Dark</a>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <div class="form-group">
                          <button class="btn btn-success" type="submit">Submit</button>
                      </div>

                      {{-- JAVASCRIPT FOR COLORS --}}
                      @section('page_bottom_scripts')
                      <script>
                          let colorArr = [
                              // PRIMARY BRANDING
                              ['#colorPrimary'],
                              ['#colorInfo'],
                              ['#colorSecondary'],
                              ['#colorWarning'],
                              ['#colorDanger'],
                              ['#colorSuccess'],
                              // OTHER COLORS
                              ['#bgBlue'],
                              ['#bgAzure'],
                              ['#bgIndigo'],
                              ['#bgPurple'],
                              ['#bgPink'],
                              ['#bgRed'],
                              ['#bgOrange'],
                              ['#bgYellow'],
                              ['#bgLime'],
                              ['#bgGreen'],
                              ['#bgTeal'],
                              ['#bgCyan'],
                              ['#bgGray'],
                              ['#bgGrayDark']
                          ];

                          function returnHex(rgb) {
                            return ("0" + parseInt(rgb).toString(16)).slice(-2);
                          }

                          $('.colorpick_code').each(function(idx, ele) {
                              let colorRGB = $(this).css('backgroundColor').match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
                              colorHex = "#" + returnHex(colorRGB[1]) + returnHex(colorRGB[2]) + returnHex(colorRGB[3]);
                              colorArr[idx].push(colorHex);
                              $(this).prev().val(colorHex);
                          });

                          colorArr.forEach(ele => {
                              $(ele[0]).spectrum({
                                  preferredFormat: "hex",
                                  color: ele[1],
                                  showAlpha: false,
                                  showInput: true,
                                  hide: function(color) {
                                      $(this).next().next().next().attr('style', `background: ${color} !important`);

                                      for (let i = 0; i < colorArr.length; i++) {
                                          if (colorArr[i][0] === $(this).attr('id')) {
                                              colorArr[i][1] = color;
                                              break;
                                          }
                                      };
                                  }
                              });
                          });
                      </script>
                      @endsection
                  </form>
              </div>

              {{-- NOTIFICATIONS AND NOTIFICATION EMAILS --}}
              <div class="tab_content tab_1_2" title="tab_1_2">
                  <div class="card">
                      <div class="card-header">
                          <h3 class="mb-0 card-title">Notification Emails</h3>
                      </div>

                      <div class="row">
                          <div class="col-sm-12">
                              <div class="card-body">
                                  <div class="form-group">
                                      Enable Notification Emailing
                                      <div class="material-switch pull-right">
                                          <input id="someSwitchOptionSuccess" name="someSwitchOption001" type="checkbox">
                                          <label for="someSwitchOptionSuccess" class="label-success"></label>
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <label class="form-label">Email for Notifications (Seperate multiple with commas)</label>
                                      <input type="text" class="form-control" name="input" placeholder="Enter Your Name">
                                  </div>
                              </div>
                          </div>
                      </div>

                      {{-- BLOG NOTIFICATIONS --}}
                      <div class="row">
                          <div class="col-sm-12">
                              <div class="card-header">
                                  <h4 class="mb-0 card-title">Blog Notifications</h4>
                              </div>
                          </div>

                          <div class="card-body col-md-6 col-sm-12">
                              <div class="form-group">
                                  New Post By Admin
                                  <div class="material-switch pull-right">
                                      <input id="someSwitchOptionSuccess" name="someSwitchOption001" type="checkbox">
                                      <label for="someSwitchOptionSuccess" class="label-success"></label>
                                  </div>
                              </div>

                              <div class="form-group">
                                  New Post By Non-Admin
                                  <div class="material-switch pull-right">
                                      <input id="someSwitchOptionSuccess" name="someSwitchOption001" type="checkbox">
                                      <label for="someSwitchOptionSuccess" class="label-success"></label>
                                  </div>
                              </div>

                              <div class="form-group">
                                  New Comments On Post
                                  <div class="material-switch pull-right">
                                      <input id="someSwitchOptionSuccess" name="someSwitchOption001" type="checkbox">
                                      <label for="someSwitchOptionSuccess" class="label-success"></label>
                                  </div>
                              </div>
                          </div>

                          <div class="card-body col-md-6 col-sm-12">
                              <div class="form-group">
                                  Post Edited
                                  <div class="material-switch pull-right">
                                      <input id="someSwitchOptionSuccess" name="someSwitchOption001" type="checkbox">
                                      <label for="someSwitchOptionSuccess" class="label-success"></label>
                                  </div>
                              </div>

                              <div class="form-group">
                                  Post Deleted
                                  <div class="material-switch pull-right">
                                      <input id="someSwitchOptionSuccess" name="someSwitchOption001" type="checkbox">
                                      <label for="someSwitchOptionSuccess" class="label-success"></label>
                                  </div>
                              </div>
                          </div>
                      </div>

                      {{-- PAGE NOTIFICATIONS --}}
                      <div class="row">
                          <div class="col-sm-12">
                              <div class="card-header">
                                  <h4 class="mb-0 card-title">Page Notifications</h4>
                              </div>
                          </div>

                          <div class="card-body col-md-6 col-sm-12">
                              <div class="form-group">
                                  New Page
                                  <div class="material-switch pull-right">
                                      <input id="someSwitchOptionSuccess" name="someSwitchOption001" type="checkbox">
                                      <label for="someSwitchOptionSuccess" class="label-success"></label>
                                  </div>
                              </div>

                              <div class="form-group">
                                  Page Deleted
                                  <div class="material-switch pull-right">
                                      <input id="someSwitchOptionSuccess" name="someSwitchOption001" type="checkbox">
                                      <label for="someSwitchOptionSuccess" class="label-success"></label>
                                  </div>
                              </div>
                          </div>

                          <div class="card-body col-md-6 col-sm-12">
                              <div class="form-group">
                                  Page Edited
                                  <div class="material-switch pull-right">
                                      <input id="someSwitchOptionSuccess" name="someSwitchOption001" type="checkbox">
                                      <label for="someSwitchOptionSuccess" class="label-success"></label>
                                  </div>
                              </div>
                          </div>
                      </div>

                      {{-- USER NOTIFICATIONS --}}
                      <div class="row">
                          <div class="col-sm-12">
                              <div class="card-header">
                                  <h4 class="mb-0 card-title">User Notifications</h4>
                              </div>
                          </div>

                          <div class="card-body col-md-6 col-sm-12">
                              <div class="form-group">
                                  Approved User Registration
                                  <div class="material-switch pull-right">
                                      <input id="someSwitchOptionSuccess" name="someSwitchOption001" type="checkbox">
                                      <label for="someSwitchOptionSuccess" class="label-success"></label>
                                  </div>
                              </div>

                              <div class="form-group">
                                  Unapproved User Registration
                                  <div class="material-switch pull-right">
                                      <input id="someSwitchOptionSuccess" name="someSwitchOption001" type="checkbox">
                                      <label for="someSwitchOptionSuccess" class="label-success"></label>
                                  </div>
                              </div>

                              <div class="form-group">
                                  Unapproved User Approved
                                  <div class="material-switch pull-right">
                                      <input id="someSwitchOptionSuccess" name="someSwitchOption001" type="checkbox">
                                      <label for="someSwitchOptionSuccess" class="label-success"></label>
                                  </div>
                              </div>
                          </div>

                          <div class="card-body col-md-6 col-sm-12">
                              <div class="form-group">
                                  User Blocked
                                  <div class="material-switch pull-right">
                                      <input id="someSwitchOptionSuccess" name="someSwitchOption001" type="checkbox">
                                      <label for="someSwitchOptionSuccess" class="label-success"></label>
                                  </div>
                              </div>

                              <div class="form-group">
                                  Group Created
                                  <div class="material-switch pull-right">
                                      <input id="someSwitchOptionSuccess" name="someSwitchOption001" type="checkbox">
                                      <label for="someSwitchOptionSuccess" class="label-success"></label>
                                  </div>
                              </div>

                              <div class="form-group">
                                  Group Approved
                                  <div class="material-switch pull-right">
                                      <input id="someSwitchOptionSuccess" name="someSwitchOption001" type="checkbox">
                                      <label for="someSwitchOptionSuccess" class="label-success"></label>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
@endcan
