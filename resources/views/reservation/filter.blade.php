<form action="" method="POST" class="form-inline float-left" id="searchForm">
    @csrf
    <input type="text" class="form-control form-control-sm mr-sm-2 mb-2" name="visitor_name" id="search_visitor_name" value="{{$visitor_name}}" placeholder="Visitor Name">
    <select class="form-control form-control-sm mr-sm-2 mb-2" name="hotel" id="search_hotel">
        <option value="" hidden>Select a Hotel</option>
        @foreach ($hotels as $item)
            <option value="{{$item->id}}" @if ($hotel_id == $item->id) selected @endif>{{$item->name}}</option>
        @endforeach
    </select>
    <select class="form-control form-control-sm mr-sm-2 mb-2" name="gm_status" id="search_gm_status">
        <option value="" hidden>General Manager Status</option>
        <option value="0" @if ($gm_status == "0") selected @endif>Pending</option>
        <option value="1" @if ($gm_status == "1") selected @endif>Rejected</option>
        <option value="2" @if ($gm_status == "2") selected @endif>Accepted</option>
    </select>
    <select class="form-control form-control-sm mr-sm-2 mb-2" name="om_status" id="search_om_status">
        <option value="" hidden>Office Manager Status</option>
        <option value="0" @if ($om_status == "0") selected @endif>Pending</option>
        <option value="1" @if ($om_status == "1") selected @endif>Rejected</option>
        <option value="2" @if ($om_status == "2") selected @endif>Accepted</option>
    </select>
    <div class="input-group">
        <span class="input-group-prepend" style="height:32px;">
            <span class="input-group-text px-2"><i class="icon-calendar22"></i></span>
        </span>
        <input type="text" class="form-control form-control-sm mr-sm-2 mb-2 daterange-basic" name="period" id="period" autocomplete="off" value="{{$period}}" placeholder="Request Date"> 
    </div>
    {{-- <input type="text" class="form-control form-control-sm mr-sm-2 mb-2" name="period" id="period" autocomplete="off" value="{{$period}}" placeholder="Request Date" style="max-width:170px;"> --}}
    <button type="submit" class="btn btn-sm btn-primary mb-2"><i class="icon-search4"></i>&nbsp;&nbsp;Search</button>
    <button type="button" class="btn btn-sm btn-info mb-2 ml-1" id="btn-reset"><i class="icon-eraser"></i>&nbsp;&nbsp;Reset</button>
</form>