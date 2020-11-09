@extends('backend/layout/'.$layout)

@section('subhead')
    <title>Dashboard - Midone - Laravel Admin Dashboard Starter Kit</title>
@endsection

@section('subcontent')
<div class="grid grid-cols-10  relative w-full h-full">
    <div class="grid grid-cols-10 w-full bg-white absolute" style="height: calc(100% - 70px)">
        <div class="col-span-2 bg-gray-200  py-3">
            <div class="grid grid-cols-2 py-6" x-data="{ tab: 'active', chat: 'chat1' }">

                <div class="col-span-1 flex items-center justify-center border-b border-gray-400">
                    <span :class="{ 'border-b-2 border-blue-700 font-bold': tab === 'active' }" @click="tab = 'active'" class=" cursor-pointer pb-3 px-3 ">Active</span>
                </div>
                <div class="col-span-1 flex items-center justify-center border-b border-gray-400">
                    <span :class="{ 'border-b-2 border-blue-700 font-bold': tab === 'aproved' }" @click="tab = 'aproved'" class="cursor-pointer pb-3 px-3">Aproved</span>
                </div>

                {{-- Active Chats --}}
                <div x-show="tab === 'active'" class="w-full col-span-2 block" >
                        <div :class="{ 'bg-white border-l-4 border-indigo-700': chat === 'chat1' }" @click="chat = 'chat1'"  class="py-5 w-full hover:bg-white cursor-pointer  flex items-center px-4 ">
                            <img src="{{asset('../img/user1.jpg')}}" class="w-12 h-12 rounded-full object-cover">
                            <div class="ml-2">
                                <h6 class="font-bold text-sm">Giorgi Saakashvili</h6>
                                <p  class="w-full text-xs font-normal" style="overflow: hidden;
                                text-overflow: ellipsis;
                                display: -webkit-box;
                                -webkit-line-clamp: 1; /* number of lines to show */
                                -webkit-box-orient: vertical;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem ipsa repellendus ducimus voluptates, esse, iste rem iure voluptas architecto provident cumque molestias, beatae saepe nobis autem officia nulla quae eius!</p>
                            </div>
                        </div>
                        
                        <div :class="{ 'bg-white border-l-4 border-indigo-700': chat === 'chat2' }" @click="chat = 'chat2'"  class="py-5 w-full hover:bg-white cursor-pointer flex items-center px-4 ">
                            <img src="{{asset('../img/user2.jpg')}}" class="w-12 h-12 rounded-full object-cover">
                            <div class="ml-2">
                                <h6 class="font-bold text-sm">Bidzina Garibashvili</h6>
                                <p  class="w-full text-xs font-normal" style="overflow: hidden;
                                text-overflow: ellipsis;
                                display: -webkit-box;
                                -webkit-line-clamp: 1; /* number of lines to show */
                                -webkit-box-orient: vertical;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem ipsa repellendus ducimus voluptates, esse, iste rem iure voluptas architecto provident cumque molestias, beatae saepe nobis autem officia nulla quae eius!</p>
                            </div>
                        </div>
                </div>

            </div>
        </div>
        {{-- Chats --}}
        <div class="col-span-8 relative">
            {{-- Chat Header --}}
            <div class="border-b py-3  px-4 border-gray-400">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <img src="{{asset('../img/user1.jpg')}}" class="w-12  object-cover rounded-full" style="height: 2.94rem">
                    <div class="ml-2">
                        <h6 class="text-sm font-bold">Giorgi Saakashvili</h6>
                        <span class="text-xs font-normal text-gray-600">
                            Money Transfer
                        </span>
                    </div>
                    </div>
                        <div x-data="{dropdown:false}" class="relative ml-2">
                            <span class="cursor-pointer" @click="dropdown = true">
                                <svg width="1.55em" height="1.55em" viewBox="0 0 16 16" class="bi bi-three-dots" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                </svg>
                            </span>
                            <div x-show="dropdown" @click.away="dropdown=false" class="py-3 bg-gray-200 px-16 absolute right-0 -mr-4 mt-6 top-full">
                                <ul class="font-medium" style="font-size: 0.8rem">
                                    <li class="py-1">
                                        <a href="" class="flex items-center">
                                            <svg width="0.9em" height="0.9em" viewBox="0 0 16 16" class="bi bi-check-circle-fill" fill="#57bd96" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                              </svg>
                                              <span class="ml-2">Aprove</span>
                                        </a>
                                    </li>
                                    <li class="py-1">
                                        <a href="" class="flex items-center">
                                            <svg width="0.9em" height="0.9em" viewBox="0 0 16 16" class="bi bi-x-circle-fill" fill="#e34d4d" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                                              </svg>
                                              <span class="ml-2">Reject</span>
                                        </a>
                                    </li>
                                    <li class="py-1">
                                        <a href="" class="flex items-center">
                                            <svg width="0.9em" height="0.9em" viewBox="0 0 16 16" class="bi bi-exclamation-circle-fill" fill="#fabd07" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                              </svg>
                                              <span class="ml-2">Report</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                </div>
            </div>

            {{-- Content --}}
            <div class="overflow-y-auto absolute " style="height: calc(100% - 125px); ">

                <div class=" py-3 px-8 w-full">
                    <div class="w-full block">
                        <div class="flex items-center">
                            <img src="{{asset('../img/user1.jpg')}}" class="w-8 h-8 object-cover rounded-full">
                            <h6 class="ml-2 font-bold">Giorgi Saakashvili</h6>
                            <span class="font-medium ml-2 text-gray-700 text-xs">3:21 PM</span>
                        </div>
                        <div class="p-2 w-1/2 mt-2 text-white rounded-md font-normal" style="background-color: #296efa">
                            <p>Hey!</p>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit architecto aliquam doloribus aliquid accusamus quod similique enim, nulla omnis ex ipsa magnam dolores. Fuga vero, voluptatum id omnis necessitatibus accusamus?</p>
                        </div>
                        
    
    
                        <div class="p-2 px-4 mt-2 text-white rounded-md font-normal" style="background-color: #296efa; width:max-content">
                           <div class="flex items-center justify-between">
                               <div>
                                    <div class="flex items-center">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-earmark-zip" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/>
                                            <path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z"/>
                                            <path fill-rule="evenodd" d="M5 7.5a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v.938l.4 1.599a1 1 0 0 1-.416 1.074l-.93.62a1 1 0 0 1-1.11 0l-.929-.62a1 1 0 0 1-.415-1.074L5 8.438V7.5zm2 0H6v.938a1 1 0 0 1-.03.243l-.4 1.598.93.62.929-.62-.4-1.598A1 1 0 0 1 7 8.438V7.5z"/>
                                            <path d="M6 1h1.5v1H6zM5 2h1.5v1H5zm1 1h1.5v1H6zM5 4h1.5v1H5zm1 1h1.5v1H6V5z"/>
                                          </svg>
                                            <h6 class="font-medium text-sm ml-2">home_Screen.jpg</h6>
                                    </div>
                                    <span class="text-xs font-normal">file size: 78kb</span>
                               </div>
                           </div>
                        </div>
                    </div>
                </div>
                
                
                <div class=" py-3 px-8 w-full">
                    <div class="w-full block">
                        <div class="flex items-center justify-end">
                            <img src="{{asset('../img/user1.jpg')}}" class="w-8 h-8 object-cover rounded-full">
                            <h6 class="ml-2 font-bold">Giorgi Saakashvili</h6>
                            <span class="font-medium ml-2 text-gray-700 text-xs">3:21 PM</span>
                        </div>
                        <div class="flex items-center justify-end">
                            
                        <div class=" p-2 w-1/2 mt-2 text-gray-700 rounded-md font-normal bg-gray-200">
                            <img src="{{asset('../img/tommy.jpg')}}" class="w-full object-cover" style="height: 370px">
                        </div>
                        </div>
                    </div>
                </div>
    
                <div class=" py-3 px-8 w-full">
                    <div class="w-full block">
                        <div class="flex items-center">
                            <img src="{{asset('../img/user1.jpg')}}" class="w-8 h-8 object-cover rounded-full">
                            <h6 class="ml-2 font-bold">Giorgi Saakashvili</h6>
                            <span class="font-medium ml-2 text-gray-700 text-xs">3:21 PM</span>
                        </div>
                        <div class="p-2 w-1/2 mt-2 text-white rounded-md font-normal" style="background-color: #296efa">
                            <p>Tomy and Jerry!</p>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit architecto aliquam doloribus aliquid accusamus quod similique enim, nulla omnis ex ipsa magnam dolores. Fuga vero, voluptatum id omnis necessitatibus accusamus?</p>
                        </div>
                    </div>
                </div>
                
                
                <div class=" py-3 px-8 w-full">
                    <div class="w-full block">
                        <div class="flex items-center justify-end">
                            <img src="{{asset('../img/user1.jpg')}}" class="w-8 h-8 object-cover rounded-full">
                            <h6 class="ml-2 font-bold">Giorgi Saakashvili</h6>
                            <span class="font-medium ml-2 text-gray-700 text-xs">3:21 PM</span>
                        </div>
                        <div class="flex items-center justify-end">
                            
                        <div class=" p-2 w-1/2 mt-2 text-gray-700 rounded-md font-normal bg-gray-200">
                            <p>Tomy and Jerry!</p>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit architecto aliquam doloribus aliquid accusamus quod similique enim, nulla omnis ex ipsa magnam dolores. Fuga vero, voluptatum id omnis necessitatibus accusamus?</p>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Send --}}
            <div class=" py-3 px-8 bottom-0 absolute w-full">
                <div class="p-3 flex items-center bg-gray-200 rounded-md">
                    <input type="text" class="w-full font-normal bg-gray-200 text-xs focus:outline-none" placeholder="Type your message..">
                    <input type="file" class="hidden" id="file">
                    <label for="file" class="cursor-pointer">
                        <svg width="1.25em" height="1.25em" viewBox="0 0 16 16" class="bi bi-cloud-arrow-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>
                            <path fill-rule="evenodd" d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2z"/>
                          </svg>
                    </label>
                    <input type="file" class="hidden" id="image">
                    <label for="image" class="cursor-pointer ml-2">
                        <svg width="1.25em" height="1.25em" viewBox="0 0 16 16" class="bi bi-card-image" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M14.5 3h-13a.5.5 0 0 0-.5.5v9c0 .013 0 .027.002.04V12l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094L15 9.499V3.5a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13zm4.502 3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                          </svg>
                    </label>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection