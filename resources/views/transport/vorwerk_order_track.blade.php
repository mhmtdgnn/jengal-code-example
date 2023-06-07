
<!DOCTYPE html>
<html lang="tr">
	<!--begin::Head-->
	<head>
		<title>Kargo Gönderi Takibi</title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta charset="utf-8" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="app-blank app-blank">
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<!--begin::Wrapper-->
			<div class="d-flex flex-column flex-column-fluid">
				<!--begin::Body-->
				<div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
					<!--begin::Email template-->
					<style>html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }</style>
					<div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
						<div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 600px;">
							<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
								<tbody>
									<tr>
										<td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
											<!--begin:Email content-->
											<div style="text-align:center; margin:0 60px 34px 60px">
												<!--begin:Logo-->
												<div style="margin-bottom: 10px">
													<a href="#//" rel="noopener" target="_blank">
														<img alt="Logo" src="{{ asset('img/vorwerk.png') }}" style="height: 75px" />
													</a>
												</div>
												<!--end:Logo-->
                                                @if($order)
                                                    <!--begin:Media-->
                                                    <div style="margin-bottom: 15px">
                                                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-11-24-050857/core/html/src/media/icons/duotune/ecommerce/ecm006.svg-->
                                                        <span class="svg-icon svg-icon-muted svg-icon-2hx">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M20 8H16C15.4 8 15 8.4 15 9V16H10V17C10 17.6 10.4 18 11 18H16C16 16.9 16.9 16 18 16C19.1 16 20 16.9 20 18H21C21.6 18 22 17.6 22 17V13L20 8Z" fill="currentColor"/>
                                                                <path opacity="0.3" d="M20 18C20 19.1 19.1 20 18 20C16.9 20 16 19.1 16 18C16 16.9 16.9 16 18 16C19.1 16 20 16.9 20 18ZM15 4C15 3.4 14.6 3 14 3H3C2.4 3 2 3.4 2 4V13C2 13.6 2.4 14 3 14H15V4ZM6 16C4.9 16 4 16.9 4 18C4 19.1 4.9 20 6 20C7.1 20 8 19.1 8 18C8 16.9 7.1 16 6 16Z" fill="currentColor"/>
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </div>
                                                    <!--end:Media-->
                                                    <!--begin:Text-->
                                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 42px; font-family:Arial,Helvetica,sans-serif">
                                                        <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">Gönderi Takibi</p>
                                                        <p style="margin-bottom:2px; color:#7E8299">Gönderinizin durumunu öğrenmek için 'Sorgula' butonuna basınız.</p>
                                                    </div>
                                                    <!--end:Text-->
                                                    <!--begin:Order-->
                                                    <div style="margin-bottom: 15px">
                                                        <!--begin:Title-->
                                                        <h3 style="text-align:left; color:#181C32; font-size: 18px; font-weight:600; margin-bottom: 22px">Sipariş Özeti</h3>
                                                        <!--end:Title-->
                                                        <!--begin:Items-->
                                                        <div style="padding-bottom:9px">
                                                            <!--begin:Item-->
                                                            <div style="display:flex; justify-content: space-between; color:#7E8299; font-size: 14px; font-weight:500; margin-bottom:8px">
                                                                <!--begin:Description-->
                                                                <div style="font-family:Arial,Helvetica,sans-serif">Fatura Ünvanı</div>
                                                                <!--end:Description-->
                                                                <!--begin:Total-->
                                                                <div style="font-family:Arial,Helvetica,sans-serif">{{ preg_replace("/(?!^).(?!$)/", "*", @$order->consumer->firstName).' '.preg_replace("/(?!^).(?!$)/", "*", @$order->consumer->lastName) }}</div>
                                                                <div style="font-family:Arial,Helvetica,sans-serif">{{ @$order->consumer->phone }}</div>
                                                                <!--end:Total-->
                                                            </div>
                                                            <!--end:Item-->
                                                            <!--begin:Item-->
                                                            <div style="display:flex; justify-content: space-between; color:#7E8299; font-size: 14px; font-weight:500; margin-bottom:8px">
                                                                <!--begin:Description-->
                                                                <div style="font-family:Arial,Helvetica,sans-serif">Teslimat Bilgisi</div>
                                                                <!--end:Description-->
                                                                <!--begin:Total-->
                                                                <div style="font-family:Arial,Helvetica,sans-serif">{{ preg_replace("/(?!^).(?!$)/", "*", @$order->teslimat_isim).' '.preg_replace("/(?!^).(?!$)/", "*", @$order->teslimat_soyisim) }}</div>
                                                                <!--end:Total-->
                                                            </div>
                                                            <!--end:Item-->
                                                            <!--begin:Item-->
                                                            <div style="display:flex; justify-content: space-between; color:#7E8299; font-size: 14px; font-weight:500;">
                                                                <!--begin:Description-->
                                                                <div style="font-family:Arial,Helvetica,sans-serif">Sipariş Kodu</div>
                                                                <!--end:Description-->
                                                                <!--begin:Total-->
                                                                <div style="font-family:Arial,Helvetica,sans-serif">{{ $order->siparis_kodu }}</div>
                                                                <!--end:Total-->
                                                            </div>
                                                            <!--end:Item-->
                                                        </div>
                                                        <!--end:Items-->
                                                    </div>
                                                    <!--end:Order-->
                                                    <div style="margin-bottom: 15px">
                                                        <!--begin:Title-->
                                                        <h3 style="text-align:left; color:#181C32; font-size: 18px; font-weight:600; margin-bottom: 22px">Sipariş Durumu</h3>
                                                        <!--end:Title-->
                                                        <div style="padding-bottom:9px">
                                                            <!--begin:Item-->
                                                            <div style="display:flex; justify-content: space-between; color:#7E8299; font-size: 14px; font-weight:500; margin-bottom:8px">
                                                                <!--begin:Description-->
                                                                @if(!empty($order->gonderi_takip_no))
                                                                <div class="badge  badge-info "><small>{{ $order->statu->title }}</small></div>
                                                                @else
                                                                <p style="margin-bottom:2px; color:#7E8299; text-align:left">Siparişiniz hazırlanıyor, kargoya teslim edildiğinde sipariş durumunuzu takip edebilmeniz için sms ile bilgilendirileceksiniz.</p>
                                                                @endif
                                                                <!--end:Description-->
                                                            </div>
                                                            <!--end:Item-->
                                                        </div>
                                                    </div>
                                                    <h3 style="text-align:left; color:#181C32; font-size: 18px; font-weight:600; margin-bottom: 22px">Kargo Bilgileri</h3>
                                                    <!--begin:Action-->
                                                    @if($order->transfer_yontemi == 'UPS')
                                                        <!--begin:Item-->
                                                        <div style="display:flex; justify-content: space-between; color:#7E8299; font-size: 14px; font-weight:500; margin-bottom:8px">
                                                            <div class="mt-4">{{ $order->gonderi_takip_no }}</div>
                                                            <a href="https://www.ups.com.tr/WaybillSorgu.aspx?Waybill={{ $order->gonderi_takip_no }}" target="_blank" style="background-color:#50cd89; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500;">Sorgula</a>
                                                        </div>
                                                        <!--end:Item-->
                                                    @endif
                                                    @if($order->transfer_yontemi == 'BİÇÖZÜM')
                                                        <a href="tel:0850 255 5545" target="_blank" style="background-color:#50cd89; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500;">Sorgula</a>
                                                    @endif
                                                    <!--begin:Action-->
                                                @else
                                                <!--begin:Text-->
                                                <div style="font-size: 14px; font-weight: 500; margin-bottom: 42px; font-family:Arial,Helvetica,sans-serif">
                                                    <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">
                                                        Sipariş Hazırlanıyor
                                                    </p>
                                                </div>
                                                <!--end:Text-->
                                                @endif
											</div>
											<!--end:Email content-->
										</td>
									</tr>
									<tr>
										<td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
											<p>&copy; Copyright Sakla Teknoloji.</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<!--end::Email template-->
				</div>
				<!--end::Body-->
			</div>
			<!--end::Wrapper-->
		</div>
		<!--end::Root-->
	</body>
	<!--end::Body-->
</html>
