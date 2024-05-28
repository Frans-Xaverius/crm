@extends('layouts.app')

@section('add-style')
    @include('laporan.whatsapp.chat.css')
@endsection

@section('content')

<div class="container-fluid">
	<div class="card shadow">
		<div class="selected-user">
			<span> Customer : <span class="name"> {{ $conversation->customer->no_telp }} - {{ $conversation->customer->nama ?? '' }}  </span></span>
		</div>
		<div class="row">
			<div class="col">
				<div class="chat-container">
					<ul class="chat-box chatContainerScroll">
						@foreach ($conversation->chat as $c)
							@if ($c->from != $adminId)
								<li class="chat-left">
									<div class="chat-avatar" style="text-align: center;">
										<i class="bi bi-person-circle h1"></i>
                                        <div class="chat-name"> Customer </div>
									</div>
									<div class="chat-text">
										 @if (empty($c->content))
										 	<a download href="{{ $_ENV['URL_WA'].'storage?folder=conversation&file='.$c->file_support }}"> 
                                                <i class="bi bi-download"> </i> {{ $c->file_support }}
                                            </a>
                                            {{ $c->caption ?? '' }}
										 @else
										 	{{ $c->content }}
										 @endif
									</div>
									<div class="chat-hour">
										{{ date('H:i', strtotime($c->created_at)) }}
									</div>
								</li>
							@else
								<li class="chat-right">
									<div class="chat-hour">
										{{ date('H:i', strtotime($c->created_at)) }}
									</div>
									<div class="chat-text">
										 @if (empty($c->content))
										 	<a download href="{{ $_ENV['URL_WA'].'storage?folder=conversation&file='.$c->file_support }}"> 
                                                <i class="bi bi-download"> </i> {{ $c->file_support }}
                                            </a>
                                            {{ $c->caption ?? '' }}
										 @else
										 	{{ $c->content }}
										 @endif
									</div>
									<div class="chat-avatar" style="text-align: center;">
										<i class="bi bi-person-circle h1"></i>
                                        <div class="chat-name"> Admin </div>
									</div>
								</li>
							@endif
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
					

@endsection

@push('js')
	@include('laporan.whatsapp.chat.script')
@endpush
