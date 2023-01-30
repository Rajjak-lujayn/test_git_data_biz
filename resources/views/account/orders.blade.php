{{--
 --}}
@extends('layouts.master')

@section('content')
	@includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
	<div class="main-container">
		<div class="container">
			<div class="row">
				
				<div class="col-md-3 page-sidebar">
					@includeFirst([config('larapen.core.customizedViewPath') . 'account.inc.sidebar', 'account.inc.sidebar'])
				</div>
				<!--/.page-sidebar-->
				
				<div class="col-md-9 page-content">
					<div class="inner-box">

					@if (Session::get('success'))
                <div class="alert alert-success text-center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                    <p>{{ Session::get('success') }}</p>
                </div>
            @endif
						<h2 class="title-2"><i class="icon-money"></i>Orders </h2>
						
						<div style="clear:both"></div>
						
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
								<tr>
									<th><span>ID</span></th>
									<th>Package</th>
									<th>{{ t('Payment Method') }}</th>
									<th>Credits</th>
									<th>{{ t('Date') }}</th>
									<th>{{ t('Status') }}</th>
								</tr>
								</thead>
								<tbody>
								<?php
							
								if (isset($orders) && $orders->count() > 0):
									foreach($orders as $key => $order):
									
										//print_r($order->pacakage->name);
								?>
								<tr>
									<td>#{{ $order->order_id}}</td>
									<td>
							{{$order->package->name}}
									</td> 
									<td>
										{{$order->payment_method->display_name}}
									</td>
									<td>{{$order->package->pictures_limit}}</td>
									<td>{{$order->created_at}}</td>
									<td>
									{{$order->order_status}}
									</td>
								</tr>
								<?php endforeach; ?>
								<?php endif; ?>
								</tbody>
							</table>
						</div>
						
						<nav aria-label="">
							{{ (isset($transactions)) ? $transactions->links() : '' }}
						</nav>
						
						<div style="clear:both"></div>
					
					</div>
				</div>
				<!--/.page-content-->
				
			</div>
			<!--/.row-->
		</div>
		<!--/.container-->
	</div>
	<!-- /.main-container -->
@endsection

@section('after_scripts')
@endsection