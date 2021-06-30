@php
  $settings       = SettingsSite::get();
  $internal_users = \RapydUser::internal_users();
@endphp

@can('sys-admin-site-settings')
  <form action="{{ route('rapyd.settings.site.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="panel panel-primary">
      <div class="tab_wrapper first_tab">
        <ul class="tab_list">
          <li class="active" rel="tab_1_1">General</li>
          <li rel="tab_1_2">SEO</li>
          <li rel="tab_1_3">CSS & JS</li>
          <li rel="tab_1_4">Security</li>
          <li rel="tab_1_5">Blog Features</li>
          <li rel="tab_1_6">PDF</li>
          <li rel="tab_1_7">Ecommerce</li>
          <li rel="tab_1_8">Policies</li>
        </ul>

        <div class="content_wrapper">
          <div class="tab_content active first tab_1_1" title="tab_1_1">
            <div class="card">
              <div class="card-body">
                <div class="form-group">
                  Enable Debugging on Site
                  <div class="material-switch pull-right">
                    <input id="sitewide_enable_debugging" name="sitewide_enable_debugging"
                      type="checkbox" onChange="this.form.submit()"
                      @if($settings['sitewide_enable_debugging']) checked @endif
                    >
                    <label for="sitewide_enable_debugging" class="label-success"></label>
                  </div>
                </div>

                <div class="form-group">
                  Clear View Cache
                  <div class="pull-right">
                    <a href="{{route('rapyd.settings.site.clear.view')}}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i>Clear Views</a>
                  </div>
                </div>

                <div class="form-group">
                  Clear DB Cache
                  <div class="pull-right">
                    <a href="{{route('rapyd.settings.site.clear.data')}}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i>Clear Data</a>
                  </div>
                </div>
              </div>
            </div>

            {{-- GENERAL SITEWIDE SETTINGS --}}
            <div class="card">
              <input type="submit" value="Save" class="btn-primary btn-save">
              <div class="card-header">
                <h3 class="mb-0 card-title">Company Info</h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <p>
                      This area is different than the PDF issuing entity info. This information
                      is what fills out general information sitewide for website vistitors 
                      which could be different than what is needed for issuing policies.
                    </p>
                  </div>
                  <div class="col-sm-6">
                    <div class="row">
                      <div class="form-group col-sm-12">
                        <label class="form-label">Street</label>
                        <input type="text" class="form-control" name="sitewide_company_street"
                          placeholder="Enter Your Street"
                          value="{{$settings['sitewide_company_street']}}">
                      </div>

                      <div class="form-group col-sm-12">
                        <label class="form-label">Street 2</label>
                        <input type="text" class="form-control" name="sitewide_company_street_2"
                          placeholder="Enter Another Street (Optional)"
                          value="{{$settings['sitewide_company_street_2']}}">
                      </div>

                      <div class="form-group col-sm-5">
                        <label class="form-label">City</label>
                        <input type="text" class="form-control" name="sitewide_company_city"
                          placeholder="Enter Your City" value="{{$settings['sitewide_company_city']}}">
                      </div>

                      <div class="form-group col-sm-3">
                        <label class="form-label">State</label>
                        <input type="text" class="form-control" name="sitewide_company_state"
                          placeholder="Enter Your State"
                          value="{{$settings['sitewide_company_state']}}">
                      </div>

                      <div class="form-group col-sm-4">
                        <label class="form-label">Zipcode</label>
                        <input type="text" class="form-control" name="sitewide_company_zip"
                          placeholder="Enter Your Zip" value="{{$settings['sitewide_company_zip']}}">
                      </div>

                      <div class="form-group col-sm-12">
                        <label class="form-label">County</label>
                        <input type="text" class="form-control" name="sitewide_company_county"
                          placeholder="Enter Your County" value="{{$settings['sitewide_company_county']}}">
                      </div>

                      <div class="form-group col-sm-12">
                        <div class="form-label">Producer Agreement</div>
                        <div class="custom-file">
                          @if($settings['sitewide_producer_agreement'])
                            <a target="_blank" href="@url('/'){{$settings['sitewide_producer_agreement']}}">Download Agreement</a>
                          @endif
                          <input type="hidden" name="old_sitewide_producer_agreement" value="{{$settings['sitewide_producer_agreement']}}" />
                          <input type="file" class="form-control" name="sitewide_producer_agreement">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="form-group col-sm-12">
                      <label class="form-label">Company Name</label>
                      <input type="text" class="form-control" name="sitewide_company_name"
                        placeholder="Enter Your Company Name"
                        value="{{$settings['sitewide_company_name']}}">
                    </div>

                    <div class="form-group col-sm-12">
                      <label class="form-label">Tax ID</label>
                      <input type="text" class="form-control" name="sitewide_company_tax_id"
                        placeholder="Enter Your Tax ID"
                        value="{{$settings['sitewide_company_tax_id']}}">
                    </div>

                    <div class="form-group col-sm-12">
                      <label class="form-label">Phone Number</label>
                      <input type="text" class="form-control" name="sitewide_company_phone"
                        placeholder="Enter Your Phone Number"
                        value="{{$settings['sitewide_company_phone']}}">
                    </div>

                    <div class="form-group col-sm-12">
                      <label class="form-label">Fax Number</label>
                      <input type="text" class="form-control" name="sitewide_company_fax"
                        placeholder="Enter Your Fax Number"
                        value="{{$settings['sitewide_company_fax']}}">
                    </div>

                    <div class="form-group col-sm-12">
                      <label class="form-label">Contact Email</label>
                      <input type="email" class="form-control" name="sitewide_email"
                        placeholder="Enter Your Email"
                        value="{{$settings['sitewide_email']}}">
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="card">
              <input type="submit" value="Save" class="btn-primary btn-save">
              <div class="card-body">
                <div class="form-group">
                  <label class="form-label">Site Title</label>
                  <input type="text" class="form-control" name="sitewide_title"
                    placeholder="Enter The Site Title"
                    value="{{$settings['sitewide_title']}}">
                </div>

                <div class="form-group">
                  <label class="form-label">Sitewide Meta Description</label>
                  <textarea class="form-control" name="sitewide_meta_description"
                    placeholder="Enter Your Name">{{$settings['sitewide_meta_description']}}</textarea>
                </div>

                <div class="form-group">
                  <label class="form-label">Sitewide Meta Keywords</label>
                  <textarea class="form-control" name="sitewide_meta_keywords"
                    placeholder="Enter Your Name">{{$settings['sitewide_meta_keywords']}}</textarea>
                </div>
                <div class="row">
                  <div class="form-group col-md-3 col-sm-12">
                    @if($settings['sitewide_favicon'])
                      <img src="{{asset($settings['sitewide_favicon'])}}" class="img-fluid">
                    @endif
                    <div class="form-label">Favicon Image</div>
                    <div class="custom-file">
                      <input type="hidden" name="old_sitewide_favicon" value="{{$settings['sitewide_favicon']}}" />
                      <input type="file" class="form-control" name="sitewide_favicon" accept=".jpg,.jpeg,.png">
                    </div>
                  </div>

                  <div class="form-group col-md-3 col-sm-12">
                    @if($settings['sitewide_logo_large'])
                      <img src="{{asset($settings['sitewide_logo_large'])}}" class="img-fluid">
                    @endif
                    <div class="form-label">Site Large Logo</div>
                    <div class="custom-file">
                      <input type="hidden" name="old_sitewide_logo_large" value="{{$settings['sitewide_logo_large']}}" />
                      <input type="file" class="form-control" name="sitewide_logo_large" accept=".jpg,.jpeg,.png">
                    </div>
                  </div>

                  <div class="form-group col-md-3 col-sm-12">
                    @if($settings['sitewide_logo_small'])
                      <img src="{{asset($settings['sitewide_logo_small'])}}" class="img-fluid">
                    @endif
                    <div class="form-label">Site Small Logo</div>
                    <div class="custom-file">
                      <input type="hidden" name="old_sitewide_logo_small" value="{{$settings['sitewide_logo_small']}}" />
                      <input type="file" class="form-control" name="sitewide_logo_small" accept=".jpg,.jpeg,.png">
                    </div>
                  </div>

                  <div class="form-group col-md-3 col-sm-12">
                    @if($settings['default_user_avatar'])
                      <img src="{{asset($settings['default_user_avatar'])}}" class="img-fluid">
                    @endif
                    <div class="form-label">Default Avatar</div>
                    <div class="custom-file">
                      <input type="hidden" name="old_default_user_avatar" value="{{$settings['default_user_avatar']}}" />
                      <input type="file" class="form-control" name="default_user_avatar" accept=".jpg,.jpeg,.png">
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="form-label">Sitewide Footer Disclaimer</label>
                  <textarea class="form-control" name="sitewide_footer_disclaimer"
                    placeholder="Enter Your Name">{{$settings['sitewide_footer_disclaimer']}}</textarea>
                </div>
              </div>
            </div>
          </div>

          {{-- SEO --}}
          <div class="tab_content tab_1_2" title="tab_1_2">
            <div class="card">
              <input type="submit" value="Save" class="btn-primary btn-save">
              <div class="card-header">
                <h3 class="mb-0 card-title">Error Reporting</h3>
              </div>
              <div class="card-body">
                <div class="form-group">
                  Enable Error Emailing
                  <div class="material-switch pull-right">
                    <input name="sitewide_email_for_errors" id="sitewide_email_for_errors"
                      type="checkbox" @if($settings['sitewide_email_for_errors']) checked @endif>
                    <label for="sitewide_email_for_errors" class="label-success"></label>
                  </div>
                </div>

                <div class="form-group">
                  Enable Weekly Report
                  <div class="material-switch pull-right">
                    <input name="sitewide_enable_weekly_reports" id="sitewide_enable_weekly_reports" type="checkbox"
                      @if($settings['sitewide_enable_weekly_reports']) checked @endif
                    >
                    <label for="sitewide_enable_weekly_reports" class="label-success"></label>
                  </div>
                </div>

                <div class="form-group">
                  Emails to Send Notifications To (separate multiple with a comma)
                  <input name="sitewide_notification_emails" class="form-control" value="{{$settings['sitewide_notification_emails']}}" />
                </div>
              </div>
            </div>

            <div class="card">
              <input type="submit" value="Save" class="btn-primary btn-save">
              <div class="card-header">
                <h3 class="mb-0 card-title">Google</h3>
              </div>
              <div class="card-body">
                <div class="form-group">
                  Enable Google Analytics
                  <div class="material-switch pull-right">
                    <input name="sitewide_enable_google_analytics" id="sitewide_enable_google_analytics" type="checkbox"
                      @if($settings['sitewide_enable_google_analytics']) checked @endif>
                    <label for="sitewide_enable_google_analytics" class="label-success"></label>
                  </div>
                </div>

                <div class="form-group">
                  <label class="form-label">Tracking ID</label>
                  <input type="text" class="form-control" name="sitewide_tracking_id"
                    placeholder="Enter Your Tracking Id"
                    value="{{$settings['sitewide_tracking_id']}}">
                </div>
              </div>
            </div>

            {{-- Site Map --}}
            <div class="card">
              <div class="card-header">
                <h3 class="mb-0 card-title">Sitemap</h3>
              </div>
              <div class="card-body">
                <a href="@url('api/core-sitemap/build')" class="btn btn-primary btn-block">Create Sitemap</a>
                <a href="/storage/main-sitemap.xml" class="btn btn-primary btn-block" download>Download
                  Sitemap</a>
              </div>
            </div>

            {{-- REINDEXING DB --}}
            {{--
             * CMS content was removed from full text search as
             * they are specific to the ap and the full text database
             * is currently being shared across apps to attempt
             * to manage I/O resources across services
            --}}
            <div class="card">
              <div class="card-header">
                <h3 class="mb-0 card-title">DB Indexing</h3>
              </div>
              <div class="card-body">
                <a href="@url('api/fulltext/reindex/class/users')" class="btn btn-primary btn-block">Reindex Users</a>
                <a href="@url('api/fulltext/reindex/class/usergroups')" class="btn btn-primary btn-block">Reindex Usergroups</a>
                <a href="@url('api/fulltext/reindex/class/bonds')" class="btn btn-primary btn-block">Reindex Bonds</a>
                {{--
                <a href="@url('api/fulltext/reindex/class/cmspages')" class="btn btn-primary btn-block">Reindex Cms Pages</a>
                <a href="@url('api/fulltext/reindex/class/cmsblog')" class="btn btn-primary btn-block">Reindex Cms Blog</a>
                --}}
                <a href="@url('api/fulltext/reindex/class/obligees')" class="btn btn-primary btn-block">Reindex Obligee</a>
                <a href="@url('api/fulltext/reindex/class/policies')" class="btn btn-primary btn-block">Reindex Policies</a>
                <a href="@url('api/fulltext/reindex/all')" class="btn btn-primary btn-block">Reindex All</a>
              </div>
            </div>
          </div>

          {{-- CSS & JS --}}
          <div class="tab_content tab_1_3" title="tab_1_3">
            <div class="card">
              <input type="submit" value="Save" class="btn-primary btn-save">
              <div class="card-body">
                <div class="form-group">
                  <label class="form-label">Sitewide Javascript</label>
                  <textarea class="form-control" name="sitewide_javascript" rows="10"
                    placeholder="Enter Your Name">{{$settings['sitewide_javascript']}}</textarea>
                </div>

                <div class="form-group">
                  <label class="form-label">Sitewide CSS</label>
                  <textarea class="form-control" name="sitewide_css" rows="10"
                    placeholder="Enter Your Name">{{$settings['sitewide_css']}}</textarea>
                </div>
              </div>
            </div>
          </div>

          {{-- SECURITY --}}
          <div class="tab_content tab_1_4" title="tab_1_4">
            <div class="card">
              <input type="submit" value="Save" class="btn-primary btn-save">
              <div class="card-body">
                {{-- BY DOMAIN --}}
                <div class="form-group">
                  <label class="form-label">Blocked Registration Domains (Comma separated)</label>
                  <textarea name="registration_blocked_domains" class="form-control" name="input" rows="10"
                    placeholder="Enter Your Name">{{$settings['registration_blocked_domains']}}</textarea>
                </div>

                {{-- BY IPS --}}
                <div class="form-group">
                  <label class="form-label">Blocked IPs (Comma separated, can take ranges also)</label>
                  <textarea name="site_blocked_ips" class="form-control" name="input" rows="10"
                    placeholder="Enter Your Name">{{$settings['site_blocked_ips']}}</textarea>
                </div>
              </div>
            </div>
          </div>

          {{-- CMS FEATURES --}}
          <div class="tab_content tab_1_5" title="tab_1_5">
            <div class="card">
                <input type="submit" value="Save" class="btn-primary btn-save">
                <div class="card-body">
                  <div class="form-group">
                    Use a url-prefix for all blog posts? (Do not add a trailing forward slash "/" to url prefix)
                    <input class="form-control" type="text" name="cms_blog_post_prefix"
                      value="{{$settings['cms_blog_post_prefix']}}">
                  </div>

                  {{-- CONTENT WRAPPER --}}
                  @php
                  $cms_content_wrappers = \Rapyd\Model\CmsContentWrapper::get();
                  @endphp
                  @if($cms_content_wrappers->first())
                  <div class="form-group">
                    <label>Default Blog Post Content Wrapper</label>
                    <select class="form-control" id="cms_blog_post_default_wrap" name='cms_blog_post_default_wrap'>
                      <option value="">None</option>
                      @foreach ($cms_content_wrappers as $wrapper)
                      <option value="{{$wrapper->blade_path}}" @if($wrapper->blade_path === $settings['cms_blog_post_default_wrap']) selected @endif>
                        {{$wrapper->description}}
                      </option>
                      @endforeach
                    </select>
                  </div>
                  @endif


                  <div class="form-group">
                    Enable Comments on Posts
                    <div class="material-switch pull-right">
                      <input name="cms_blog_comment_posts" id="cms_blog_comment_posts" type="checkbox"
                        @if($settings['cms_blog_comment_posts']) checked @endif>
                      <label for="cms_blog_comment_posts" class="label-success"></label>
                    </div>
                  </div>

                  {{-- TEMP: UNSURE IF PAGES WILL EVER HAVE COMMENTS --}}
                  {{-- <div class="form-group">
                    Enable Comments on Pages
                    <div class="material-switch pull-right">
                      <input type="hidden" name="cms-blog-comment-pages" value="0">
                      <input id="cms-blog-comment-pages" name="cms_blog_comment-pages" type="checkbox" value="1"
                        @if(AdminSettings::get('cms-blog-comment-pages')) checked @endif>
                      <label for="cms-blog-comment-pages" class="label-success"></label>
                    </div>
                  </div> --}}

                  <div class="form-group">
                    Enable Links in Comments by Default
                    <div class="material-switch pull-right">
                      <input name="cms_blog_links_in_comments" id="cms_blog_links_in_comments" type="checkbox"
                        @if($settings['cms_blog_links_in_comments']) checked @endif>
                      <label for="cms_blog_links_in_comments" class="label-success"></label>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="form-label">Blocked Words in Comments (Comma separated)</label>
                    <textarea class="form-control" rows="10"
                      placeholder="Enter Your Name" name="cms_blog_block_words"
                      >{{$settings['cms_blog_block_words']}}</textarea>
                  </div>
                </div>
            </div>
          </div>

          {{-- PDF SETTINGS --}}
          <div class="tab_content tab_1_6" title="tab_1_6">
            <div class="card">
              {{-- GENERAL USER BEHAVIOR SETTINGS --}}
              <input type="submit" value="Save" class="btn-primary btn-save">
              <div class="card-body">
                <div class="form-group">
                  <label class="form-label">Base Download Limit (Zero 0 for unlimited)</label>
                  <input type="text" class="form-control" name="pdf_base_download_limit" value="{{$settings['pdf_base_download_limit']}}">
                </div>

                <div class="form-group">
                  <label class="form-label">PDF File Fetch Path (Include trailing forward slash "/")</label>
                  <input type="text" class="form-control" name="pdf_file_fetch_path" value="{{$settings['pdf_file_fetch_path']}}">
                </div>

                <div class="form-group">
                  <label class="form-label">PDF Thumbnail Fetch Path (Include trailing forward slash "/")</label>
                  <input type="text" class="form-control" name="pdf_thumbnail_fetch_path" value="{{$settings['pdf_thumbnail_fetch_path']}}">
                </div>

                <div class="form-group">
                  <label class="form-label">PDF Save Path</label>
                  <input type="text" class="form-control" name="pdf_save_path" value="{{$settings['pdf_save_path']}}">
                </div>

                <div class="form-group">
                  @if($settings['pdf_site_signature'])
                    <img src="{{asset($settings['pdf_site_signature'])}}" class="img-fluid">
                  @endif
                  <label class="form-label">PDF Site Signature</label>
                  <div class="custom-file">
                    <input type="hidden" name="old_pdf_site_signature" value="{{$settings['pdf_site_signature']}}" />
                    <input type="file" class="form-control" name="pdf_site_signature" accept=".jpg,.jpeg,.png">
                  </div>
                </div>

                <div class="form-group">
                  <label class="form-label">PDF Site Signature Text</label>
                  <input type="text" class="form-control" name="pdf_site_signature_text" value="{{$settings['pdf_site_signature_text']}}">
                </div>
                <div class="form-group">
                  <label class="form-label" for="sitewide_company_agreement_terms">PDF Agreement Terms</label>
                  <textarea class="form-control richTextBox" id="sitewide_company_agreement_terms"
                  name="sitewide_company_agreement_terms">{!! $settings['sitewide_company_agreement_terms'] !!}</textarea>
                </div>

                <div class="form-group">
                  <label class="form-label" for="pdf_application_indemnity">Indemnity Agreement</label>
                  <textarea class="form-control richTextBox" id="pdf_application_indemnity"
                  name="pdf_application_indemnity">{!! $settings['pdf_application_indemnity'] !!}</textarea>
                </div>
              </div>
            </div>

            {{-- WITNESS INFORMATION FOR PDF FORMATION --}}
            <div class="card">
              <input type="submit" value="Save" class="btn-primary btn-save">
              <div class="card-body row">
                {{-- Witness 1 --}}
                <div class="form-group col-md-9 col-sm-12">
                  <label class="form-label">Witness 1 Name</label>
                  <input type="text" class="form-control" name="pdf_witness_1_name" value="{{$settings['pdf_witness_1_name']}}">
                </div>

                <div class="form-group col-md-3 col-sm-12">
                  @if($settings['pdf_witness_1_signature_file'])
                    <img src="{{asset($settings['pdf_witness_1_signature_file'])}}" class="img-fluid">
                  @endif
                  <div class="form-label">Witness 1 Image</div>
                  <div class="custom-file">
                    <input type="hidden" name="old_pdf_witness_1_signature_file" value="{{$settings['pdf_witness_1_signature_file']}}" />
                    <input type="file" class="form-control" name="pdf_witness_1_signature_file" accept=".jpg,.jpeg,.png">
                  </div>
                </div>

                {{-- Witness 2 --}}
                <div class="form-group col-md-9 col-sm-12">
                  <label class="form-label">Witness 2 Name</label>
                  <input type="text" class="form-control" name="pdf_witness_2_name" value="{{$settings['pdf_witness_2_name']}}">
                </div>

                <div class="form-group col-md-3 col-sm-12">
                  @if($settings['pdf_witness_2_signature_file'])
                    <img src="{{asset($settings['pdf_witness_2_signature_file'])}}" class="img-fluid">
                  @endif
                  <div class="form-label">Witness 2 Image</div>
                  <div class="custom-file">
                    <input type="hidden" name="old_pdf_witness_2_signature_file" value="{{$settings['pdf_witness_2_signature_file']}}" />
                    <input type="file" class="form-control" name="pdf_witness_2_signature_file" accept=".jpg,.jpeg,.png">
                  </div>
                </div>
              </div>
            </div>

            {{-- NOTARY INFORMATION FOR PDF FORMATION --}}
            <div class="card">
              <input type="submit" value="Save" class="btn-primary btn-save">
              <div class="card-body row">
                {{-- Notary Info --}}
                <div class="form-group col-md-7 col-sm-12">
                  <label class="form-label">Notary Name</label>
                  <input type="text" class="form-control" name="pdf_notary_name" value="{{$settings['pdf_notary_name']}}">
                </div>

                <div class="form-group col-md-5 col-sm-12">
                  <label class="form-label">Commission Date End</label>
                  <input type="text" class="form-control" name="pdf_notary_commission_end" value="{{$settings['pdf_notary_commission_end']}}">
                </div>

                {{-- NOTARY ADDRESS INFO --}}
                <div class="form-group col-sm-12">
                  <label class="form-label">Street</label>
                  <input type="text" class="form-control" name="pdf_notary_street"
                    placeholder="Enter Your Street"
                    value="{{$settings['pdf_notary_street']}}">
                </div>

                <div class="form-group col-sm-5">
                  <label class="form-label">City</label>
                  <input type="text" class="form-control" name="pdf_notary_city"
                    placeholder="Enter Your City" value="{{$settings['pdf_notary_city']}}">
                </div>

                <div class="form-group col-sm-3">
                  <label class="form-label">State</label>
                  <input type="text" class="form-control" name="pdf_notary_state"
                    placeholder="Enter Your State"
                    value="{{$settings['pdf_notary_state']}}">
                </div>

                <div class="form-group col-sm-4">
                  <label class="form-label">Zipcode</label>
                  <input type="text" class="form-control" name="pdf_notary_zip"
                    placeholder="Enter Your Zip" value="{{$settings['pdf_notary_zip']}}">
                </div>

                <div class="form-group col-sm-12">
                  <label class="form-label">County</label>
                  <input type="text" class="form-control" name="pdf_notary_county"
                    placeholder="Enter Your County" value="{{$settings['pdf_notary_county']}}">
                </div>

                {{-- Required Images --}}
                <div class="form-group col-md-6 col-sm-12">
                  @if($settings['pdf_notary_seal_image'])
                    <img src="{{asset($settings['pdf_notary_seal_image'])}}" class="img-fluid">
                  @endif
                  <div class="form-label">Notary Seal</div>
                  <div class="custom-file">
                    <input type="hidden" name="old_pdf_notary_seal_image" value="{{$settings['pdf_notary_seal_image']}}" />
                    <input type="file" class="form-control" name="pdf_notary_seal_image" accept=".jpg,.jpeg,.png">
                  </div>
                </div>

                <div class="form-group col-md-6 col-sm-12">
                  @if($settings['pdf_notary_signature_image'])
                    <img src="{{asset($settings['pdf_notary_signature_image'])}}" class="img-fluid">
                  @endif
                  <div class="form-label">Notary Signature</div>
                  <div class="custom-file">
                    <input type="hidden" name="old_pdf_notary_signature_image" value="{{$settings['pdf_notary_signature_image']}}" />
                    <input type="file" class="form-control" name="pdf_notary_signature_image" accept=".jpg,.jpeg,.png">
                  </div>
                </div>
              </div>
            </div>

            {{-- ISSUING BUSINESS INFORMATION FOR PDF FORMATION --}}
            <div class="card">
              <input type="submit" value="Save" class="btn-primary btn-save">
              <div class="card-body row">
                <div class="col-12">
                  <p>
                    This area is different than the sitewide company info. This information
                    is what fills out issued policy information which could be different
                    than what is required to be outputted on the website itself.
                  </p>
                </div>
        
                <div class="form-group col-sm-12">
                  <label class="form-label">Issuing Entity Name</label>
                  <input type="text" class="form-control" name="pdf_issue_entity_name" value="{{$settings['pdf_issue_entity_name']}}">
                </div>

                <div class="form-group col-md-5 col-sm-12">
                  <label class="form-label">Address</label>
                  <input type="text" class="form-control" name="pdf_issue_entity_address" value="{{$settings['pdf_issue_entity_address']}}">
                </div>

                <div class="form-group col-md-3 col-sm-12">
                  <label class="form-label">City</label>
                  <input type="text" class="form-control" name="pdf_issue_entity_city" value="{{$settings['pdf_issue_entity_city']}}">
                </div>

                <div class="form-group col-md-2 col-sm-12">
                  <label class="form-label">State</label>
                  <input type="text" class="form-control" name="pdf_issue_entity_state" value="{{$settings['pdf_issue_entity_state']}}">
                </div>

                <div class="form-group col-md-2 col-sm-12">
                  <label class="form-label">Zip</label>
                  <input type="text" class="form-control" name="pdf_issue_entity_zip" value="{{$settings['pdf_issue_entity_zip'] ?? ''}}">
                </div>

                <div class="form-group col-md-4">
                  <label class="form-label">County</label>
                  <input type="text" class="form-control" name="pdf_issue_entity_county" value="{{$settings['pdf_issue_entity_county'] ?? ''}}">
                </div>

                <div class="form-group col-md-4">
                  <label class="form-label">Phone</label>
                  <input type="text" class="form-control" name="pdf_issue_entity_phone" value="{{$settings['pdf_issue_entity_phone'] ?? ''}}">
                </div>
                <div class="form-group col-md-4">
                  <label class="form-label">Fax</label>
                  <input type="text" class="form-control" name="pdf_issue_entity_fax" value="{{$settings['pdf_issue_entity_fax'] ?? ''}}">
                </div>

                <div class="form-group col-md-6">
                  <label class="form-label">Email</label>
                  <input type="text" class="form-control" name="pdf_issue_entity_email" value="{{$settings['pdf_issue_entity_email'] ?? ''}}">
                </div>
                <div class="form-group col-md-6">
                  <label class="form-label">Tax ID</label>
                  <input type="text" class="form-control" name="pdf_issue_entity_tax_id" value="{{$settings['pdf_issue_entity_tax_id'] ?? ''}}">
                </div>
              </div>
            </div>
          </div>

          {{-- ECOMMERCE --}}
          <div class="tab_content tab_1_7" title="tab_1_7">
            <div class="card">
              <input type="submit" value="Save" class="btn-primary btn-save">
              <div class="card-body row mt-6 mb-4">
                <div class="col-5">
                  <label class="form-label">Ecommerce Dev User</label>
                  <input type="text" class="form-control" name="ecommerce_dev_user"
                    placeholder="Ecommerce Dev User"
                    value="{{$settings['ecommerce_dev_user']}}"
                  >
                </div>
                <div class="col-5">
                  <label class="form-label">Ecommerce Dev Key</label>
                  <input type="text" class="form-control" name="ecommerce_dev_key"
                    placeholder="Ecommerce Dev Key"
                    value="{{$settings['ecommerce_dev_key']}}"
                  >
                </div>
                <div class="col-2 mt-6">
                  <div class="form-group">
                    <label class="custom-switch">
                      <input type="checkbox" name="ecommerce_sandbox_mode" class="custom-switch-input"
                        @if($settings['ecommerce_sandbox_mode']) checked @endif
                      >
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">
                        Enable Sandbox
                      </span>
                    </label>
                  </div>
                </div>
                <div class="col-5">
                  <label class="form-label">Production Dev User</label>
                  <input type="text" class="form-control" name="ecommerce_prod_user"
                    placeholder="Ecommerce Production Key"
                    value="{{$settings['ecommerce_prod_user']}}"
                  >
                </div>
                <div class="col-5">
                  <label class="form-label">Production Dev Key</label>
                  <input type="text" class="form-control" name="ecommerce_prod_key"
                    placeholder="Ecommerce Production Key"
                    value="{{$settings['ecommerce_prod_key']}}"
                  >
                </div>
              </div>
            </div>
          </div>

          {{-- POLICIES --}}
          <div class="tab_content last tab_1_8" title="tab_1_8">
            <div class="card">
              <input type="submit" value="Save" class="btn-primary btn-save">
              <div class="card-body row mt-6 mb-4">
                <div class="col-12">
                  <select class="form-control" name="system_policy_domain_source">
                    <option value='bondexchange'>Bond Exchange</option>
                    <option value='jet'>JET</option>
                  </select>
                </div>
                <div class="col-6">
                  <label class="form-label">System Default Policy Agent</label>
                  <select class="form-control" name="system_policy_default_agent">
                    <option value>--Select Agent--</option>
                    @foreach($internal_users as $user)
                      <option 
                        value="{{$user->id}}" 
                        @if($settings['system_policy_default_agent'] == $user->id) selected @endif 
                      >{{$user->full_name()}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-6">
                  <label class="form-label">Default User Group</label>
                  @if($default_group = \m_Usergroups::find($settings['system_policy_default_usergroup']))
                    <a target="_blank" href="@url('/admin/usergroups/profile?group='){{$default_group->id}}">
                      {{$default_group->name}}
                    </a>
                  @else
                    No Usergroup Attached to Default User
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
  <script src="https://cdn.tiny.cloud/1/sciq4hgol5faritl7pux7z8gazeni4fj5bkebpkgbkueunhk/tinymce/5/tinymce.min.js"></script>
  <script src="/modules/System/Resources/Admin/js/settings_site.js"></script>
@endcan
