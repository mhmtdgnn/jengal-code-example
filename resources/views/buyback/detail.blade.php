@extends('common.layout')

@section('content')
        <!--begin::Container-->
        <div class="container-xxl" id="kt_content_container">
            <!--begin::Layout-->
            <div class="d-flex flex-column flex-xl-row">
                <!--begin::Sidebar-->
                <div class="flex-column flex-lg-row-auto w-100 w-xl-400px mb-10">
                    <!--begin::Card-->
                    <div class="card mb-5 mb-xl-8">
                        <!--begin::Card body-->
                        <div class="card-body pt-5">
                            <!--begin::Details toggle-->
                            <div class="d-flex flex-stack fs-4 py-3">
                                <div class="fw-bold">Talep Detayı (#{{ $buybackRequest->id }})</div>
                            </div>
                            <!--end::Details toggle-->
                            <div class="separator separator-dashed my-3"></div>
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered">
                                    <!--begin::Table body-->
                                    <tbody class="fw-semibold text-gray-600">
                                    <!--begin::Payment method-->
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <!--begin::Svg Icon | path: icons/duotune/finance/fin008.svg-->
                                                <span class="svg-icon svg-icon-2 me-2">
																	<svg width="24" height="24" viewBox="0 0 24 24"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path opacity="0.3"
                                                                              d="M3.20001 5.91897L16.9 3.01895C17.4 2.91895 18 3.219 18.1 3.819L19.2 9.01895L3.20001 5.91897Z"
                                                                              fill="currentColor"></path>
																		<path opacity="0.3"
                                                                              d="M13 13.9189C13 12.2189 14.3 10.9189 16 10.9189H21C21.6 10.9189 22 11.3189 22 11.9189V15.9189C22 16.5189 21.6 16.9189 21 16.9189H16C14.3 16.9189 13 15.6189 13 13.9189ZM16 12.4189C15.2 12.4189 14.5 13.1189 14.5 13.9189C14.5 14.7189 15.2 15.4189 16 15.4189C16.8 15.4189 17.5 14.7189 17.5 13.9189C17.5 13.1189 16.8 12.4189 16 12.4189Z"
                                                                              fill="currentColor"></path>
																		<path
                                                                            d="M13 13.9189C13 12.2189 14.3 10.9189 16 10.9189H21V7.91895C21 6.81895 20.1 5.91895 19 5.91895H3C2.4 5.91895 2 6.31895 2 6.91895V20.9189C2 21.5189 2.4 21.9189 3 21.9189H19C20.1 21.9189 21 21.0189 21 19.9189V16.9189H16C14.3 16.9189 13 15.6189 13 13.9189Z"
                                                                            fill="currentColor"></path>
																	</svg>
																</span>
                                                <!--end::Svg Icon-->Teklif Seçimi
                                            </div>
                                        </td>
                                        <td class="fw-bold text-end">{{ empty($buybackRequest->IBAN) ? "Nakit" : "Hediye Çeki" }}</td>
                                    </tr>
                                    <!--end::Payment method-->
                                    <!--begin::Shipping Method-->
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm006.svg-->
                                                <span class="svg-icon svg-icon-2 me-2">
																	<svg width="24" height="24" viewBox="0 0 24 24"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path
                                                                            d="M20 8H16C15.4 8 15 8.4 15 9V16H10V17C10 17.6 10.4 18 11 18H16C16 16.9 16.9 16 18 16C19.1 16 20 16.9 20 18H21C21.6 18 22 17.6 22 17V13L20 8Z"
                                                                            fill="currentColor"></path>
																		<path opacity="0.3"
                                                                              d="M20 18C20 19.1 19.1 20 18 20C16.9 20 16 19.1 16 18C16 16.9 16.9 16 18 16C19.1 16 20 16.9 20 18ZM15 4C15 3.4 14.6 3 14 3H3C2.4 3 2 3.4 2 4V13C2 13.6 2.4 14 3 14H15V4ZM6 16C4.9 16 4 16.9 4 18C4 19.1 4.9 20 6 20C7.1 20 8 19.1 8 18C8 16.9 7.1 16 6 16Z"
                                                                              fill="currentColor"></path>
																	</svg>
																</span>
                                                <!--end::Svg Icon-->Kargo Metodu
                                            </div>
                                        </td>
                                        <td class="fw-bold text-end">{{ empty($buybackRequest->address) ? "Kargo" : "BiKurye" }}</td>
                                    </tr>
                                    <!--end::Shipping Method-->
                                    <!--begin::Rewards-->
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm011.svg-->
                                                <span class="svg-icon svg-icon-2 me-2">
																	<svg width="24" height="24" viewBox="0 0 24 24"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path opacity="0.3"
                                                                              d="M21.6 11.2L19.3 8.89998V5.59993C19.3 4.99993 18.9 4.59993 18.3 4.59993H14.9L12.6 2.3C12.2 1.9 11.6 1.9 11.2 2.3L8.9 4.59993H5.6C5 4.59993 4.6 4.99993 4.6 5.59993V8.89998L2.3 11.2C1.9 11.6 1.9 12.1999 2.3 12.5999L4.6 14.9V18.2C4.6 18.8 5 19.2 5.6 19.2H8.9L11.2 21.5C11.6 21.9 12.2 21.9 12.6 21.5L14.9 19.2H18.2C18.8 19.2 19.2 18.8 19.2 18.2V14.9L21.5 12.5999C22 12.1999 22 11.6 21.6 11.2Z"
                                                                              fill="currentColor"></path>
																		<path
                                                                            d="M11.3 9.40002C11.3 10.2 11.1 10.9 10.7 11.3C10.3 11.7 9.8 11.9 9.2 11.9C8.8 11.9 8.40001 11.8 8.10001 11.6C7.80001 11.4 7.50001 11.2 7.40001 10.8C7.20001 10.4 7.10001 10 7.10001 9.40002C7.10001 8.80002 7.20001 8.4 7.30001 8C7.40001 7.6 7.7 7.29998 8 7.09998C8.3 6.89998 8.7 6.80005 9.2 6.80005C9.5 6.80005 9.80001 6.9 10.1 7C10.4 7.1 10.6 7.3 10.8 7.5C11 7.7 11.1 8.00005 11.2 8.30005C11.3 8.60005 11.3 9.00002 11.3 9.40002ZM10.1 9.40002C10.1 8.80002 10 8.39998 9.90001 8.09998C9.80001 7.79998 9.6 7.70007 9.2 7.70007C9 7.70007 8.8 7.80002 8.7 7.90002C8.6 8.00002 8.50001 8.2 8.40001 8.5C8.40001 8.7 8.30001 9.10002 8.30001 9.40002C8.30001 9.80002 8.30001 10.1 8.40001 10.4C8.40001 10.6 8.5 10.8 8.7 11C8.8 11.1 9 11.2001 9.2 11.2001C9.5 11.2001 9.70001 11.1 9.90001 10.8C10 10.4 10.1 10 10.1 9.40002ZM14.9 7.80005L9.40001 16.7001C9.30001 16.9001 9.10001 17.1 8.90001 17.1C8.80001 17.1 8.70001 17.1 8.60001 17C8.50001 16.9 8.40001 16.8001 8.40001 16.7001C8.40001 16.6001 8.4 16.5 8.5 16.4L14 7.5C14.1 7.3 14.2 7.19998 14.3 7.09998C14.4 6.99998 14.5 7 14.6 7C14.7 7 14.8 6.99998 14.9 7.09998C15 7.19998 15 7.30002 15 7.40002C15.2 7.30002 15.1 7.50005 14.9 7.80005ZM16.6 14.2001C16.6 15.0001 16.4 15.7 16 16.1C15.6 16.5 15.1 16.7001 14.5 16.7001C14.1 16.7001 13.7 16.6 13.4 16.4C13.1 16.2 12.8 16 12.7 15.6C12.5 15.2 12.4 14.8001 12.4 14.2001C12.4 13.3001 12.6 12.7 12.9 12.3C13.2 11.9 13.7 11.7001 14.5 11.7001C14.8 11.7001 15.1 11.8 15.4 11.9C15.7 12 15.9 12.2 16.1 12.4C16.3 12.6 16.4 12.9001 16.5 13.2001C16.6 13.4001 16.6 13.8001 16.6 14.2001ZM15.4 14.1C15.4 13.5 15.3 13.1 15.2 12.9C15.1 12.6 14.9 12.5 14.5 12.5C14.3 12.5 14.1 12.6001 14 12.7001C13.9 12.8001 13.8 13.0001 13.7 13.2001C13.6 13.4001 13.6 13.8 13.6 14.1C13.6 14.7 13.7 15.1 13.8 15.4C13.9 15.7 14.1 15.8 14.5 15.8C14.8 15.8 15 15.7 15.2 15.4C15.3 15.2 15.4 14.7 15.4 14.1Z"
                                                                            fill="currentColor"></path>
																	</svg>
																</span>
                                                <!--end::Svg Icon-->Ön Teklif
                                            </div>
                                        </td>
                                        <td class="fw-bold text-end">{{ $buybackRequest->bid_price }} ₺</td>
                                    </tr>
                                    <!--end::Rewards-->
                                    <!--begin::Customer name-->
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                                <span class="svg-icon svg-icon-2 me-2">
																	<svg width="18" height="18" viewBox="0 0 18 18"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path opacity="0.3"
                                                                              d="M16.5 9C16.5 13.125 13.125 16.5 9 16.5C4.875 16.5 1.5 13.125 1.5 9C1.5 4.875 4.875 1.5 9 1.5C13.125 1.5 16.5 4.875 16.5 9Z"
                                                                              fill="currentColor"></path>
																		<path
                                                                            d="M9 16.5C10.95 16.5 12.75 15.75 14.025 14.55C13.425 12.675 11.4 11.25 9 11.25C6.6 11.25 4.57499 12.675 3.97499 14.55C5.24999 15.75 7.05 16.5 9 16.5Z"
                                                                            fill="currentColor"></path>
																		<rect x="7" y="6" width="4" height="4" rx="2"
                                                                              fill="currentColor"></rect>
																	</svg>
																</span>
                                                <!--end::Svg Icon-->Müşteri
                                            </div>
                                        </td>
                                        <td class="fw-bold text-end">
                                            <a href="" class="text-hover-primary">{{ $buybackRequest->first_name}} {{ $buybackRequest->last_name}}</a>
                                        </td>
                                    </tr>
                                    <!--end::Customer name-->
                                    <!--begin::Customer email-->
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <!--begin::Svg Icon | path: icons/duotune/communication/com011.svg-->
                                                <span class="svg-icon svg-icon-2 me-2">
																	<svg width="24" height="24" viewBox="0 0 24 24"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path opacity="0.3"
                                                                              d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19Z"
                                                                              fill="currentColor"></path>
																		<path
                                                                            d="M21 5H2.99999C2.69999 5 2.49999 5.10005 2.29999 5.30005L11.2 13.3C11.7 13.7 12.4 13.7 12.8 13.3L21.7 5.30005C21.5 5.10005 21.3 5 21 5Z"
                                                                            fill="currentColor"></path>
																	</svg>
																</span>
                                                <!--end::Svg Icon-->E-posta
                                            </div>
                                        </td>
                                        <td class="fw-bold text-end">
                                            <a href="" class="text-hover-primary">{{ $buybackRequest->email}}</a>
                                        </td>
                                    </tr>
                                    <!--end::Payment method-->
                                    <!--begin::Phone-->
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <!--begin::Svg Icon | path: icons/duotune/electronics/elc003.svg-->
                                                <span class="svg-icon svg-icon-2 me-2">
																	<svg width="24" height="24" viewBox="0 0 24 24"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path
                                                                            d="M5 20H19V21C19 21.6 18.6 22 18 22H6C5.4 22 5 21.6 5 21V20ZM19 3C19 2.4 18.6 2 18 2H6C5.4 2 5 2.4 5 3V4H19V3Z"
                                                                            fill="currentColor"></path>
																		<path opacity="0.3" d="M19 4H5V20H19V4Z"
                                                                              fill="currentColor"></path>
																	</svg>
																</span>
                                                <!--end::Svg Icon-->Telefon
                                            </div>
                                        </td>
                                        <td class="fw-bold text-end">{{ $buybackRequest->phone}}</td>
                                    </tr>
                                    <!--end::Phone-->
                                    <!--begin::Invoice-->
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm008.svg-->
                                                <span class="svg-icon svg-icon-2 me-2">
                                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                                         xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3"
                                                          d="M18 21.6C16.3 21.6 15 20.3 15 18.6V2.50001C15 2.20001 14.6 1.99996 14.3 2.19996L13 3.59999L11.7 2.3C11.3 1.9 10.7 1.9 10.3 2.3L9 3.59999L7.70001 2.3C7.30001 1.9 6.69999 1.9 6.29999 2.3L5 3.59999L3.70001 2.3C3.50001 2.1 3 2.20001 3 3.50001V18.6C3 20.3 4.3 21.6 6 21.6H18Z"
                                                          fill="currentColor"></path>
                                                    <path
                                                        d="M12 12.6H11C10.4 12.6 10 12.2 10 11.6C10 11 10.4 10.6 11 10.6H12C12.6 10.6 13 11 13 11.6C13 12.2 12.6 12.6 12 12.6ZM9 11.6C9 11 8.6 10.6 8 10.6H6C5.4 10.6 5 11 5 11.6C5 12.2 5.4 12.6 6 12.6H8C8.6 12.6 9 12.2 9 11.6ZM9 7.59998C9 6.99998 8.6 6.59998 8 6.59998H6C5.4 6.59998 5 6.99998 5 7.59998C5 8.19998 5.4 8.59998 6 8.59998H8C8.6 8.59998 9 8.19998 9 7.59998ZM13 7.59998C13 6.99998 12.6 6.59998 12 6.59998H11C10.4 6.59998 10 6.99998 10 7.59998C10 8.19998 10.4 8.59998 11 8.59998H12C12.6 8.59998 13 8.19998 13 7.59998ZM13 15.6C13 15 12.6 14.6 12 14.6H10C9.4 14.6 9 15 9 15.6C9 16.2 9.4 16.6 10 16.6H12C12.6 16.6 13 16.2 13 15.6Z"
                                                        fill="currentColor"></path>
                                                    <path
                                                        d="M15 18.6C15 20.3 16.3 21.6 18 21.6C19.7 21.6 21 20.3 21 18.6V12.5C21 12.2 20.6 12 20.3 12.2L19 13.6L17.7 12.3C17.3 11.9 16.7 11.9 16.3 12.3L15 13.6V18.6Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </span>
                                                <!--end::Svg Icon-->Talep No
                                            </div>
                                        </td>
                                        <td class="fw-bold text-end">
                                            <a href="" class="text-hover-primary">#{{ $buybackRequest->id }}</a>
                                        </td>
                                    </tr>
                                    <!--end::Invoice-->
                                    <!--begin::Date-->
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <!--begin::Svg Icon | path: icons/duotune/files/fil002.svg-->
                                                <span class="svg-icon svg-icon-2 me-2">
                                                <svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3"
                                                          d="M19 3.40002C18.4 3.40002 18 3.80002 18 4.40002V8.40002H14V4.40002C14 3.80002 13.6 3.40002 13 3.40002C12.4 3.40002 12 3.80002 12 4.40002V8.40002H8V4.40002C8 3.80002 7.6 3.40002 7 3.40002C6.4 3.40002 6 3.80002 6 4.40002V8.40002H2V4.40002C2 3.80002 1.6 3.40002 1 3.40002C0.4 3.40002 0 3.80002 0 4.40002V19.4C0 20 0.4 20.4 1 20.4H19C19.6 20.4 20 20 20 19.4V4.40002C20 3.80002 19.6 3.40002 19 3.40002ZM18 10.4V13.4H14V10.4H18ZM12 10.4V13.4H8V10.4H12ZM12 15.4V18.4H8V15.4H12ZM6 10.4V13.4H2V10.4H6ZM2 15.4H6V18.4H2V15.4ZM14 18.4V15.4H18V18.4H14Z"
                                                          fill="currentColor"></path>
                                                    <path
                                                        d="M19 0.400024H1C0.4 0.400024 0 0.800024 0 1.40002V4.40002C0 5.00002 0.4 5.40002 1 5.40002H19C19.6 5.40002 20 5.00002 20 4.40002V1.40002C20 0.800024 19.6 0.400024 19 0.400024Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </span>
                                                <!--end::Svg Icon-->Talep Tarihi
                                            </div>
                                        </td>
                                        <td class="fw-bold text-end">{{ $buybackRequest->created_at }}</td>
                                    </tr>
                                    <!--end::Date-->
                                    <!--begin::Date-->
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <!--begin::Svg Icon | path: icons/duotune/files/fil002.svg-->
                                                <span class="svg-icon svg-icon-2 me-2">
                                                <svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3"
                                                          d="M19 3.40002C18.4 3.40002 18 3.80002 18 4.40002V8.40002H14V4.40002C14
                                                          3.80002 13.6 3.40002 13 3.40002C12.4 3.40002 12 3.80002 12
                                                          4.40002V8.40002H8V4.40002C8 3.80002 7.6 3.40002 7 3.40002C6.4 3.40002 6
                                                          3.80002 6 4.40002V8.40002H2V4.40002C2 3.80002 1.6 3.40002 1 3.40002C0.4
                                                          3.40002 0 3.80002 0 4.40002V19.4C0 20 0.4 20.4 1 20.4H19C19.6 20.4 20 20
                                                          20 19.4V4.40002C20 3.80002 19.6 3.40002 19 3.40002ZM18 10.4V13.4H14V10.4H18ZM12
                                                          10.4V13.4H8V10.4H12ZM12 15.4V18.4H8V15.4H12ZM6 10.4V13.4H2V10.4H6ZM2 15.4H6V18.4H2V15.4ZM14
                                                          18.4V15.4H18V18.4H14Z"
                                                          fill="currentColor"></path>
                                                    <path
                                                        d="M19 0.400024H1C0.4 0.400024 0 0.800024 0 1.40002V4.40002C0 5.00002 0.4 5.40002 1
                                                        5.40002H19C19.6 5.40002 20 5.00002 20 4.40002V1.40002C20 0.800024 19.6 0.400024 19 0.400024Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </span>
                                                <!--end::Svg Icon-->Güncelleme Tarihi
                                            </div>
                                        </td>
                                        <td class="fw-bold text-end">{{ $buybackRequest->updated_at }}</td>
                                    </tr>
                                    <!--end::Date-->
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>

                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Sidebar-->
                <!--begin::Content-->
                <div class="flex-lg-row-fluid ms-lg-15">
                    <!--begin:::Tabs-->
                    <div class="d-flex flex-wrap flex-stack gap-5 gap-lg-10 mb-8">
                        <!--begin:::Tabs-->
                        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold" role="tablist">
                            <!--begin:::Tab item-->
                            <li class="nav-item" role="presentation">
                                <a class="nav-link nav-link-white text-active-white pb-4 active" data-bs-toggle="tab"
                                   href="#tab_detaylar" aria-selected="true" role="tab">Detaylar</a>
                            </li>
                            <!--end:::Tab item-->
                            <!--begin:::Tab item-->
                            <li class="nav-item" role="presentation">
                                <a class="nav-link nav-link-white text-active-white pb-4" data-bs-toggle="tab"
                                   href="#tab_cevaplar" aria-selected="false" tabindex="-1"
                                   role="tab">Cevaplar</a>
                            </li>
                            <!--end:::Tab item-->
                            <!--begin:::Tab item-->
                            <li class="nav-item" role="presentation">
                                <a class="nav-link nav-link-white text-active-white pb-4" data-bs-toggle="tab"
                                   href="#tab_logs" aria-selected="false" tabindex="-1"
                                   role="tab">Logs</a>
                            </li>
                            <!--end:::Tab item-->
                        </ul>
                        <!--end:::Tabs-->
                        <!--begin::Button-->
                        <a href="/metronic8/demo9/../demo9/apps/ecommerce/sales/listing.html" class="btn btn-icon btn-light btn-sm ms-auto me-lg-n7">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr074.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.2657 11.4343L15.45 7.25C15.8642 6.83579 15.8642 6.16421 15.45 5.75C15.0358 5.33579 14.3642 5.33579 13.95 5.75L8.40712 11.2929C8.01659 11.6834 8.01659 12.3166 8.40712 12.7071L13.95 18.25C14.3642 18.6642 15.0358 18.6642 15.45 18.25C15.8642 17.8358 15.8642 17.1642 15.45 16.75L11.2657 12.5657C10.9533 12.2533 10.9533 11.7467 11.2657 11.4343Z" fill="currentColor"></path>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </a>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <a href="" class="btn btn-success btn-sm me-lg-n7 disabled">Düzenle</a>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <a href="" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_3">İşlem</a>
                        <!--end::Button-->
                    </div>
                    <!--end:::Tabs-->
                    <!--begin:::Tab content-->
                    <div class="tab-content" id="myTabContent">
                        <!--begin:::Tab pane-->
                        <div class="tab-pane fade show active" id="tab_detaylar" role="tabpanel">
                            <div class="row row-cols-1 row-cols-md-2 mb-6 mb-xl-9">
                                <div class="col">
                                    <!--begin::Card-->
                                    <div class="card pt-4 h-md-100 mb-6 mb-md-0">
                                        <!--begin::Background-->
                                        <div
                                            class="position-absolute top-0 end-0 opacity-10 pe-none text-end">
                                            <img
                                                src="{{asset('assets/media/icons/duotune/ecommerce/ecm006.svg')}}"
                                                class="w-125px"/>
                                        </div>
                                        <!--end::Background-->
                                        <!--begin::Card header-->
                                        <div class="card-header border-0">
                                            <!--begin::Card title-->
                                            <div class="card-title">
                                                <h2 class="fw-bold">Ürün Alım Adresi</h2>
                                            </div>
                                            <!--end::Card title-->
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <div class="fw-bold fs-2">
                                                <div class="fs-7 fw-normal text-muted">
                                                    @if(empty($buybackRequest->address))
                                                        Müşteri ürünü kendisi kargoya teslim edecek.
                                                    @else
                                                        {{ $buybackRequest->address}},
                                                        <br>{{ $buybackRequest->town->name}},
                                                        <br>{{ $buybackRequest->city->name}}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Card-->
                                </div>
                                <div class="col">
                                    <!--begin::Card-->
                                    <div class="card pt-4 h-md-100 mb-6 mb-md-0">
                                        <!--begin::Background-->
                                        <div
                                            class="position-absolute top-0 end-0 opacity-10 pe-none text-end">
                                            <img
                                                src="{{asset('assets/media/icons/duotune/finance/fin001.svg')}}"
                                                class="w-125px"/>
                                        </div>
                                        <!--end::Background-->
                                        <!--begin::Card header-->
                                        <div class="card-header border-0">
                                            <!--begin::Card title-->
                                            <div class="card-title">
                                                <h2 class="fw-bold">Ödeme Bilgileri</h2>
                                            </div>
                                            <!--end::Card title-->
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <div class="fw-bold fs-2">
                                                <div class="fs-7 fw-normal text-muted">
                                                    @if(empty($buybackRequest->IBAN))
                                                        Banka bilgisi bulunmuyor.
                                                    @else
                                                        IBAN: {{ $buybackRequest->IBAN}}
                                                        <br>Kart Üstündeki
                                                        İsim: {{ $buybackRequest->bank_cardholder_name}}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Card-->
                                </div>
                            </div>
                            <!--begin::Card-->
                            <div class="card pt-4 mb-6 mb-xl-9">
                                <!--begin::Card header-->
                                <div class="card-header border-0">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <h2>Ürün bilgileri</h2>
                                    </div>
                                    <!--end::Card title-->
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-0 pb-5">
                                    <!--begin::Table-->
                                    <div id="kt_table_customers_payment_wrapper"
                                         class="dataTables_wrapper dt-bootstrap4 no-footer">
                                        <div class="table-responsive">
                                            <!--begin::Table-->
                                            <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                                <!--begin::Table head-->
                                                <thead>
                                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                    <th class="min-w-175px">Ürün</th>
                                                    <th class="min-w-100px text-end">Marka</th>
                                                    <th class="min-w-100px text-end">Ön Teklif</th>
                                                </tr>
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody class="fw-semibold text-gray-600">
                                                <!--begin::Products-->
                                                <tr>
                                                    <!--begin::Product-->
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <!--begin::Thumbnail-->
                                                            <a href="#" class="symbol symbol-70px">
                                                                <span
                                                                    class="symbol-label"
                                                                    style="background-image:url(https://cdn.yenigibial.com/buyback/product-images/{{$buybackRequest->product->image_url }});">
                                                                </span>
                                                            </a>
                                                            <!--end::Thumbnail-->
                                                            <!--begin::Title-->
                                                            <div class="ms-5">
                                                                {{ $buybackRequest->brand_id == 9999 ? $buybackRequest->other_product : $buybackRequest->product->name }}
                                                            </div>
                                                            <!--end::Title-->
                                                        </div>
                                                    </td>
                                                    <!--end::Product-->
                                                    <!--begin::SKU-->
                                                    <td class="text-end">{{ $buybackRequest->brand_id == 9999 ? $buybackRequest->other_brand : $buybackRequest->brand->name }}</td>
                                                    <!--end::SKU-->
                                                    <!--begin::Price-->
                                                    <td class="text-end">{{ $buybackRequest->bid_price }} ₺</td>
                                                    <!--end::Price-->
                                                </tr>
                                                </tbody>
                                                <!--end::Table head-->
                                            </table>
                                            <!--end::Table-->
                                        </div>
                                    </div>
                                    <!--end::Table-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card-->
                        </div>
                        <!--end:::Tab pane-->
                        <!--begin:::Tab pane-->
                        <div class="tab-pane fade" id="tab_cevaplar" role="tabpanel">

                            <!--begin::Orders-->
                            <div class="d-flex flex-column gap-7 gap-lg-10">
                                <!--begin::Soru Cevapları-->
                                <div class="card card-flush py-4 flex-row-fluid">
                                    <!--begin::Card header-->
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Soru Cevapları</h2>
                                        </div>
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Input group-->
                                        <div class="row fv-row mb-7">

                                            @foreach ($question as $item)

                                                <div class="col-md-6 text-md-end">
                                                    <!--begin::Label-->
                                                    <label class="fs-6 fw-semibold form-label mt-3">
                                                        <span>{{ $item->question  ?? "Soru Seti Id Yok" }}</span>
                                                        <i class="fas fa-exclamation-circle ms-1 fs-7"
                                                           data-bs-toggle="tooltip"
                                                           aria-label="Enable/disable tracking customers online status."
                                                           data-kt-initialized="1"></i>
                                                    </label>
                                                    <!--end::Label-->
                                                </div>

                                                    <?php $labours = json_decode($buybackRequest->questions, true); ?>

                                                <div class="col-md-6">
                                                    <div class="d-flex mt-3">
                                                        @switch($labours['soru'.$item->index])
                                                            @case('1')
                                                                <!--begin::Radio-->
                                                                <div
                                                                    class="form-check form-check-custom form-check-solid me-5">
                                                                    <input class="form-check-input" type="radio"
                                                                           value=""
                                                                           name="customers_soru{{$item->index}}"
                                                                           id="customers_online_yes"
                                                                           checked="checked" disabled>
                                                                    <label class="form-check-label"
                                                                           for="customers_online_yes">Evet</label>
                                                                </div>
                                                                <div
                                                                    class="form-check form-check-custom form-check-solid">
                                                                    <input class="form-check-input" type="radio"
                                                                           value=""
                                                                           name="customers_soru{{$item->index}}"
                                                                           id="customers_online_no" disabled>
                                                                    <label class="form-check-label"
                                                                           for="customers_online_no">Hayır</label>
                                                                </div>
                                                                <!--end::Radio-->
                                                                @break

                                                            @case('2')
                                                                <!--begin::Radio-->
                                                                <div
                                                                    class="form-check form-check-custom form-check-solid me-5">
                                                                    <input class="form-check-input" type="radio"
                                                                           value=""
                                                                           name="customers_soru{{$item->index}}"
                                                                           id="customers_online_yes" disabled>
                                                                    <label class="form-check-label"
                                                                           for="customers_online_yes">Evet</label>
                                                                </div>
                                                                <div
                                                                    class="form-check form-check-custom form-check-solid">
                                                                    <input class="form-check-input" type="radio"
                                                                           value=""
                                                                           name="customers_soru{{$item->index}}"
                                                                           id="customers_online_no"
                                                                           checked="checked" disabled>
                                                                    <label class="form-check-label"
                                                                           for="customers_online_no">Hayır</label>
                                                                </div>
                                                                <!--end::Radio-->
                                                                @break

                                                            @default
                                                                <span class="status">Belli Değil</span>
                                                        @endswitch
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Soru Cevapları-->
                            </div>
                            <!--end::Orders-->
                        </div>
                        <!--end:::Tab pane-->
                        <!--begin:::Tab pane-->
                        <div class="tab-pane fade" id="tab_logs" role="tabpanel">
                            <!--begin::Talep Geçmişleri-->
                            <div class="d-flex flex-column gap-7 gap-lg-10">
                                <!--begin::Talep Geçmişi-->
                                <div class="card card-flush py-4 flex-row-fluid">
                                    <!--begin::Card header-->
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Talep Geçmişi</h2>
                                        </div>
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <div class="table-responsive">
                                            <!--begin::Table-->
                                            <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_ecommerce_category_table">
                                                <!--begin::Table head-->
                                                <thead>
                                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                    <th class="min-w-100px">Eklenme Tarihi</th>
                                                    <th class="min-w-175px">Açıklama</th>
                                                    <th class="min-w-60px">Talep Statüsü</th>
                                                    <th class="min-w-30px">Bildirimi</th>
                                                </tr>
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody class="fw-semibold text-gray-600">
                                                    @foreach ($log as $item)
                                                    <tr>
                                                        <!--begin::Date-->
                                                        <td>
                                                            <i class="far fa-calendar"></i>
                                                            {{ date_format($item['created_at'],"Y-m-d")}}
                                                            <i class="far fa-clock"></i>
                                                            {{ date_format($item['created_at'],"H:i")}}
                                                        </td>
                                                        <!--end::Date-->
                                                        <!--begin::Comment-->
                                                        <td>{{ $item['comment'] }}</td>
                                                        <!--end::Comment-->
                                                        <!--begin::Status-->
                                                        <td>
                                                            <!--begin::Badges-->
                                                            <div class="badge badge-light-{{ $item['status']['color'] }}">{{ $item['status']['name'] }}</div>
                                                            <!--end::Badges-->
                                                        </td>
                                                        <!--end::Status-->
                                                        <!--begin::Customer Notified-->
                                                        <td>No</td>
                                                        <!--end::Customer Notified-->
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                <!--end::Table head-->
                                            </table>
                                            <!--end::Table-->
                                        </div>
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Talep Geçmişi-->
                                
                                <!--begin::Talep Geçmişi-->
                                <div class="card card-flush py-4 mb-6 mb-xl-9">
                                    <!--begin::Card header-->
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Talep Geçmişi Ekleyin</h2>
                                        </div>
                                    </div>
                                    <!--end::Card header-->

                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <form action="{{ route('buyback.buyback_request_log', $buybackRequest->id) }}" method="post">
                                            @csrf
                                            <div class="fv-row w-100 flex-md-root fv-plugins-icon-container mb-8" data-select2-id="select2-data-128-hvdg">
                                                <!--begin::Label-->
                                                <label class="required form-label">Talep Durumu</label>
                                                <!--end::Label-->
                                                <!--begin::Select2-->
                                                <select class="form-select mb-2 select2-hidden-accessible" name="talep_status" data-control="select2" data-hide-search="true" data-placeholder="Talep Durumu" data-select2-id="select2-data-13-08jz" tabindex="-1" aria-hidden="true" data-kt-initialized="1" required>
                                                    <option data-select2-id="select2-data-137-2gfx"></option>
                                                    @foreach ($status as $item)
                                                        <option value="{{ $item['id'] }}" data-select2-id="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                                    @endforeach
                                                </select>
                                                <!--end::Select2-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">Talep durumunu seçin</div>
                                                <!--end::Description-->
                                            </div>

                                            <div class="fv-row fv-plugins-icon-container">
                                                <!--begin::Label-->
                                                <label class="required form-label">Açıklama</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <textarea class="form-control mb-2" name="status_aciklama" placeholder="Açıklama" aria-label="With textarea" required></textarea>
                                                <!--end::Input-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">Ek bilgi varsa ekleyin.</div>
                                                <!--end::Description-->
                                            </div>

                                            <input type="hidden" name="talep_id" value="{{ $buybackRequest->id }}">

                                            <!--begin::Button-->
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <button type="submit" class="btn btn-primary mt-3" id="kt_button_1" >
                                                    <span class="indicator-label">
                                                        Güncelle
                                                    </span>
                                                    <span class="indicator-progress">
                                                        Lütfen bekleyin... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                    </span>
                                                </button>
                                            </div>
                                            <!--end::Button-->

                                        </form>
                                    </div>
                                    <!--end::Card body-->

                                </div>
                                <!--end::Talep Geçmişi-->

                            </div>
                            <!--end::Talep Geçmişleri-->
                        </div>
                        <!--end:::Tab pane-->
                    </div>
                    <!--end:::Tab content-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Layout-->
        </div>
        <!--end::Container-->

        <div class="modal fade" tabindex="-1" id="kt_modal_3">
            <div class="modal-dialog">
                <div class="modal-content position-absolute">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
        
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <span class="svg-icon svg-icon-2x"></span>
                        </div>
                        <!--end::Close-->
                    </div>
        
                    <div class="modal-body">
                        <p>Modal body text goes here.</p>
                    </div>
        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('footer_scripts')
        <script>
            // Element to indecate
            var button = document.querySelector("#kt_button_1");

            // Handle button click event
            button.addEventListener("click", function() {
                // Activate indicator
                button.setAttribute("data-kt-indicator", "on");
                button.classList.add("disabled");
            
                // Disable indicator after 3 seconds
                setTimeout(function() {
                    button.removeAttribute("data-kt-indicator");
                    button.classList.remove("disabled");
                }, 3000);
            });
        </script>

        <script>
        // Make the DIV element draggable:
        var element = document.querySelector('#kt_modal_3');
        dragElement(element);

        function dragElement(elmnt) {
            var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
            if (elmnt.querySelector('.modal-content')) {
                // if present, the header is where you move the DIV from:
                elmnt.querySelector('.modal-content').onmousedown = dragMouseDown;
            } else {
                // otherwise, move the DIV from anywhere inside the DIV:
                elmnt.onmousedown = dragMouseDown;
            }
        
            function dragMouseDown(e) {
                e = e || window.event;
                e.preventDefault();
                // get the mouse cursor position at startup:
                pos3 = e.clientX;
                pos4 = e.clientY;
                document.onmouseup = closeDragElement;
                // call a function whenever the cursor moves:
                document.onmousemove = elementDrag;
            }
        
            function elementDrag(e) {
                e = e || window.event;
                e.preventDefault();
                // calculate the new cursor position:
                pos1 = pos3 - e.clientX;
                pos2 = pos4 - e.clientY;
                pos3 = e.clientX;
                pos4 = e.clientY;
                // set the element's new position:
                elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
                elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
            }
        
            function closeDragElement() {
                // stop moving when mouse button is released:
                document.onmouseup = null;
                document.onmousemove = null;
            }
        }     
        </script>

        <!--begin::Vendors Javascript(used by this page)-->
        <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/categories.js') }}"></script>
        <!--end::Vendors Javascript-->
@endsection
