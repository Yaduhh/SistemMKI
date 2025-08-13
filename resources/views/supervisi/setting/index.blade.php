<x-layouts.supervisi title="Settings">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center">
                                <span class="text-2xl font-bold text-amber-600">{{ auth()->user()->initials() }}</span>
                            </div>
                        </div>
                        <div class="ml-6">
                            <h1 class="text-2xl font-bold text-gray-900">
                                {{ auth()->user()->name }}
                            </h1>
                            <p class="text-gray-600">{{ auth()->user()->email }}</p>
                            <p class="text-sm text-amber-600 font-medium">Role: Supervisi</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Profile Settings</h3>
                        <p class="text-gray-600 mb-4">Update your profile information and account details.</p>
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-amber-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-700 focus:bg-amber-700 active:bg-amber-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Edit Profile
                        </a>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Password</h3>
                        <p class="text-gray-600 mb-4">Ensure your account is using a long, random password to stay secure.</p>
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-amber-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-700 focus:bg-amber-700 active:bg-amber-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Change Password
                        </a>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Appearance</h3>
                        <p class="text-gray-600 mb-4">Customize the appearance of your dashboard and interface.</p>
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-amber-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-700 focus:bg-amber-700 active:bg-amber-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Customize
                        </a>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Notifications</h3>
                        <p class="text-gray-600 mb-4">Manage your notification preferences and email settings.</p>
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-amber-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-700 focus:bg-amber-700 active:bg-amber-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Configure
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.supervisi>
