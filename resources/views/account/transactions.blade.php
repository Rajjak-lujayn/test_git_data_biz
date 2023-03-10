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
						<h2 class="title-2"><i class="icon-money"></i> {{ t('Transactions') }} </h2>
						
						<div style="clear:both"></div>
						
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
								<tr>
									<th><span>ID</span></th>
									<th>{{ t('Description') }}</th>
									<th>{{ t('Payment Method') }}</th>
									<th>{{ t('Value') }}</th>
									<th>{{ t('Date') }}</th>
									<th>{{ t('Status') }}</th>
								</tr>
								</thead>
								<tbody>
								<?php
								if (isset($transactions) && $transactions->count() > 0):
									foreach($transactions as $key => $transaction):
										
										// Fixed 2
										if (empty($transaction->post)) continue;
										if (!$countries->has($transaction->post->country_code)) continue;
										
										if (empty($transaction->package)) continue;
								?>
								<tr>
									<td>#{{ $transaction->id }}</td>
									<td>
										<a href="{{ \App\Helpers\UrlGen::post($transaction->post) }}">{{ $transaction->post->title }}</a><br>
										<strong>{{ t('type') }}</strong> {{ $transaction->package->short_name }} <br>
										<strong>{{ t('Duration') }}</strong> {{ $transaction->package->duration }} {{ t('days') }}
									</td>
									<td>
										@if ($transaction->active == 1)
											@if (!empty($transaction->paymentMethod))
												{{ t('Paid by') }} {{ $transaction->paymentMethod->display_name }}
											@else
												{{ t('Paid by') }} --
											@endif
										@else
											{{ t('Pending payment') }}
										@endif
									</td>
									<td>{!! ((!empty($transaction->package->currency)) ? $transaction->package->currency->symbol : '') . '' . $transaction->package->price !!}</td>
									<td>{!! $transaction->created_at_formatted !!}</td>
									<td>
										@if ($transaction->active == 1)
											<span class="badge badge-success">{{ t('Done') }}</span>
										@else
											<span class="badge badge-info">{{ t('Pending') }}</span>
										@endif
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