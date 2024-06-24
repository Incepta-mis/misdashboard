<table class="table table-condensed table-striped table-hover" ng-show="viewType === 'L'">
    <thead>
    <tr>
        <th>../{{$folder_pt[0]->folder_path}}(Files/Folders)-   @if(Auth::user()->plant_id === '1100') (Zirabo) @else (Dhamrai) @endif</th>
        <th>Action</th>
{{--        {{$folder_pt[0]->folder_path}}--}}
    </tr>
    </thead>
    <tbody ng-cloak="">
    <tr ng-if="showBackIcon" ng-cloak="">
        <td colspan="2" ng-click="navigateBack()" style="color: #0f81cc;padding: 6px;">
            <span class="badge badge-warning" title="Go to Root Folder">
                <i class="fa fa-home" style="font-size: 18px;" ng-click="goto_root()"></i>
            </span> |
            <span class="badge badge-warning" title="Go back">
                <img src="{{url('public/site_resource/images/ibd_img/leftarrow.png')}}" alt="" width="15px">
                <span class="text">@{{ navtext_full }}</span>
            </span>
        </td>
    </tr>
    <tr ng-repeat="f in root_dir | filter:searchStr" ng-cloak="">
        <td>
            <span class="trow" ng-click="row_clicked(f)" title="@{{ f.text.split('|')[0] }}@{{ f.text.split('|')[2] }}">
                <img ng-src="@{{ f.text.split('|')[1] }}" alt="" width="30px"/>
                @{{ f.text.split('|')[0] }}@{{ f.text.split('|')[2] }}
            </span>
        </td>
        <td>
            <button class="btn btn-sm btn-success" ng-if="f.text.split('|')[2] !== '...'" ng-click="open_dialog(f)">
                <i class="fa fa-eye"></i> View
            </button>
        </td>
    </tr>
    <tr ng-if="loadingContent">
        <td colspan="2" style="padding: 0;">
            <img src="{{url('public/site_resource/images/ibd_img/skeleton_page.gif')}}" alt="" width="100%"
                 height="220px">
        </td>
    </tr>
    <tr ng-if="isEmpty" ng-cloak="">
        <td colspan="2" class="text-center">
            <img src="{{url('public/site_resource/images/ibd_img/nofile.png')}}" ng-if="isEmpty" alt="">
            <br><span>No Item in this Folder</span>
        </td>
    </tr>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="2">Total Files: <span class="badge badge-warning">@{{ root_dir.length }}</span></td>
    </tr>
    </tfoot>
</table>