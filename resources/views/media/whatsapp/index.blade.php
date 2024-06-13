@extends('layouts.app')

@section('add-style')
@include('media.whatsapp.css')
@endsection

@section('content')

<div class="container-fluid pb-1 pt-3 pt-md-1">
    <div class="card mt-3 mb-5 p-2">
        <div class="card-body">
            <div class="row">

                <div class="col-md-3">
                    <div class="d-flex flex-row justify-content-start mb-3">
                        <input type="text" class="form-control form-control-alternative search-customer" placeholder="Cari Customer">
                    </div>
                    <div data-mdb-perfect-scrollbar="true" style="position: relative; height: calc(100vh - 287px); overflow-y: scroll;">
                        <div class="list-group chat-queue" style="width: 100%" id="room">
                            @foreach ($conversation as $c)
                                <a href="#" class="list-group-item list-group-item-action border-bottom p-2 list-customer" onclick="setConversation('{{ $c->id }}')">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex flex-row">
                                            <img src="/assets/img/user.png" alt="avatar" class="rounded-circle d-flex align-self-center me-3 shadow-1-strong mr-2" width="40">
                                            <div class="pt-1">
                                                <p class="fw-bold mb-0 font-weight-bold">
                                                    {{ $c->customer->nama ?? $c->customer->no_telp }}
                                                </p>
                                                <p class="small text-muted text-msg" attr-convid="{{ $c->id }}">
                                                    {{ $c->chat->reverse()->first()->content ?? '' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach 
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="pt-3 pe-3 pr-3 mt-3" style="height: calc(100vh - 287px);overflow-y: scroll; padding: 2%;" id="room-detail">
                        
                    </div>
                </div>

                <div class="col-md-3">

                    <fieldset class="border border-dark">
                        <legend class="w-auto" style="font-size: 20px; text-align: center;"> Info Nomor </legend>
                        <div class="p-3">
                            <div class="form-group">
                                <label> Nomor Telepon </label>
                                <input type="text" class="form-control form-control-sm field-nomor" readonly>
                            </div>
                            <div class="form-group">
                                <label> Nama (Alias) </label>
                                <input type="text" class="form-control form-control-sm field-nama" readonly>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="border border-dark mt-3 mb-3">
                        <legend class="w-auto" style="font-size: 20px; text-align: center;"> Tag </legend>
                        <form class="p-3" method="POST" enctype="multipart/form-data" action="{{ route('media.whatsapp.set-tag') }}">
                            @csrf
                            <input type="hidden" class="input-tag" name="conv_id">
                            <div class="form-group">
                                <label> Tag </label>
                                <select class="form-control tags" name="tags[]" multiple>
                                    @foreach($tag as $t)
                                        <option value="{{ $t->id }}"> {{ $t->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="btn btn-info btn-sm mb-3" style="float: right;"> Simpan Tag </button>
                        </form>
                    </fieldset>

                    @if(auth()->user()->detailRole->name == "Super Admin")
                        <fieldset class="border border-dark mt-3 mb-3">
                            <legend class="w-auto" style="font-size: 20px; text-align: center;"> Eskalasi </legend>
                            <form class="p-3" method="POST" enctype="multipart/form-data" action="{{ route('media.whatsapp.eskalasi') }}">
                                @csrf
                                <input type="hidden" name="conv_id" class="input-eks" />
                                <div class="form-group mt-3">
                                    <label> User </label>
                                    <select class="form-control form-control-sm eks-select" name="user_id">
                                        <option selected disabled> -- Pilih -- </option>
                                        @foreach($users as $u)
                                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button class="btn btn-info btn-sm mb-3" style="float: right;"> Simpan Eskalasi </button>
                            </form>
                        </fieldset>
                    @endif

                    <div class="mt-5">
                        <button class="btn btn-sm btn-danger do-complete" style="float: right;"> Akhiri Sesi </button>
                    </div>

                </div>
            </div>

            <div class="text-muted d-flex justify-content-end align-items-center mt-5 mb-3">
                <textarea class="form-control form-control-lg content-msg" placeholder="Tulis pesan..." rows="3"></textarea>
            </div>

            <div class="d-flex justify-content-right align-items-center mt-1 mb-2 field-btn" style="float: right;">
                <div class="pt-1 d-flex">
                    <div class="btn-group">
                        <button class="ms-4 btn btn-secondary do-attachment">
                            <i class="fa fa-file" aria-hidden="true"></i>
                        </button>
                        <button class="ms-4 btn btn-primary do-send">
                            Kirim &nbsp; <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>  
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@push('js')
@include('media.whatsapp.script')
@endpush
