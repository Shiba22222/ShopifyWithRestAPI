@extends('admins.layouts.master',['title' => 'Login Install and Register WebhookProduct'])
@section('content')
    <br>
<form action="{{route('huskadian')}}" method="GET" >
    @csrf
    <div class="input-group mb-3" style="text-align: center">
        <label class="input-group-text" for="">Mời nhập tên Store:</label>
        <input type="text" name="shop" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" value="huskadian2" aria-describedby="basic-addon2">
        <span class="input-group-text" id="basic-addon2">.myshopify.com</span>
    </div>
    <input type="submit" value="Submit">
</form>
@endsection
