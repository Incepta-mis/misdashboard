<div class="col-md-12" ng-show="viewType === 'G'">
    <div ng-if="showBackIcon" ng-cloak="" style="margin-top: 10px;">
        <div ng-click="navigateBack()" style="color: #0f81cc;padding: 6px;background-color: ghostwhite;cursor: pointer;"class="trow">
            <span class="badge badge-warning" title="Go to Root Folder">
                <i class="fa fa-home" style="font-size: 18px;" ng-click="goto_root()"></i>
            </span> |
            <span class="badge badge-warning" title="Go back">
                <img src="{{url('public/site_resource/images/ibd_img/leftarrow.png')}}" alt="" width="15px">
                <span class="text">@{{ navtext_full }}</span>
            </span>
        </div>
    </div>
    <hr ng-if="showBackIcon">
    <div class="row" style="margin: 10px;" ng-cloak="">
        <div class="col-md-2 col-sm-2 col-xs-2" ng-repeat="f in root_dir | filter:searchStr" ng-cloak=""
             ng-click="row_clicked(f)">
            <div class="file-man-box">
                <div class="file-img-box">
                    <img ng-src="@{{ f.text.split('|')[1] }}" alt="icon">
                </div>
                <a href="#" class="file-download" title="Print Document" ng-if="f.text.split('|')[2] !== '...'" ng-click="open_dialog(f)">
                    <i class="fa fa-print"></i>
                </a>
                <div class="file-man-title">
                    <h5 class="mb-0 text-overflow" title="@{{ f.text.split('|')[0] }}@{{ f.text.split('|')[2] }}">
                        @{{ f.text.split('|')[0] }}@{{ f.text.split('|')[2] }}
                    </h5>
{{--                    <p class="mb-0"><small>568.8 kb</small></p>--}}
                </div>
            </div>
        </div>
        <div ng-if="isEmpty" ng-cloak="">
            <div colspan="2" class="text-center">
                <img src="{{url('public/site_resource/images/ibd_img/nofile.png')}}" alt="">
                <br><span>No Item in this Folder</span>
            </div>
        </div>
    </div>

    <hr>
    <div style="padding: 10px;">Total Files: <span class="badge badge-warning">@{{ root_dir.length }}</span></div>
</div>
