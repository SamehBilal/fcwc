<?php

use Livewire\Volt\Component;
use App\Models\GameUser;

new class extends Component {}; ?>

<x-layouts.app :title="__('Dashboard')">

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        {{-- <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div> --}}
        <div class="relative h-full flex-1 overflow-hidden {{-- rounded-xl border border-neutral-200 dark:border-neutral-700 --}}">
            {{-- <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" /> --}}


            <div class="ptable">
                <h1 class="headin text-lg font-bold">Standings</h1>
                <table>
                    <tr class="col">
                        <th>#</th>
                        <th>Player</th>
                        <th>Questions</th>
                        <th>Groups</th>
                        <th>Knockouts</th>
                        <th>Game4</th>
                        <th>Game5</th>
                        <th>PTS</th>
                    </tr>
                    <tr class="wpos">
                        <td>1</td>
                        <td>Warriors FC</td>
                        <td>2</td>
                        <td>2</td>
                        <td>0</td>
                        <td>0</td>
                        <td>5</td>
                        <td>6</td>
                    </tr>
                    <tr class="wpos">
                        <td>2</td>
                        <td>YOLO FC</td>
                        <td>2</td>
                        <td>2</td>
                        <td>0</td>
                        <td>0</td>
                        <td>4</td>
                        <td>6</td>
                    </tr>
                    <tr class="wpos">
                        <td>3</td>
                        <td>Majestic A</td>
                        <td>2</td>
                        <td>1</td>
                        <td>1</td>
                        <td>0</td>
                        <td>4</td>
                        <td>4</td>
                    </tr>
                    <tr class="wpos">
                        <td>4</td>
                        <td>Fenris</td>
                        <td>2</td>
                        <td>1</td>
                        <td>1</td>
                        <td>0</td>
                        <td>1</td>
                        <td>4</td>
                    </tr>
                    <tr class="pos">
                        <td>5</td>
                        <td>La Masia</td>
                        <td>2</td>
                        <td>1</td>
                        <td>0</td>
                        <td>1</td>
                        <td>0</td>
                        <td>3</td>
                    </tr>
                    <tr class="pos">
                        <td>6</td>
                        <td>Ultra Sort FC</td>
                        <td>3</td>
                        <td>1</td>
                        <td>0</td>
                        <td>2</td>
                        <td>-1</td>
                        <td>3</td>
                    </tr>
                    <tr class="pos">
                        <td>7</td>
                        <td>Wasseypur FC</td>
                        <td>2</td>
                        <td>1</td>
                        <td>0</td>
                        <td>1</td>
                        <td>-2</td>
                        <td>3</td>
                    </tr>
                    <tr class="pos">
                        <td>8</td>
                        <td>Majestic B</td>
                        <td>1</td>
                        <td>0</td>
                        <td>1</td>
                        <td>0</td>
                        <td>0</td>
                        <td>1</td>
                    </tr>
                    <tr class="pos">
                        <td>9</td>
                        <td>Not So Hot Spurs</td>
                        <td>2</td>
                        <td>0</td>
                        <td>1</td>
                        <td>1</td>
                        <td>-1</td>
                        <td>1</td>
                    </tr>
                    <tr class="pos">
                        <td>10</td>
                        <td>Silver Hawks</td>
                        <td>2</td>
                        <td>0</td>
                        <td>0</td>
                        <td>2</td>
                        <td>-4</td>
                        <td>0</td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
</x-layouts.app>
