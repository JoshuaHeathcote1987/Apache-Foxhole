@extends('layouts.app')
@section('content')
    <div class="w-75 central-content pb-5 px-0 mx-0">
        <div class="mx-3">
            <h1 class="mt-4">Home |</h1>
            <hr>
            <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                <strong>Login Successful!</strong> Take your time to read to guidelines below and understand the structure
                of our organization.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="card my-3">
                <div class="card-header">
                    Quote
                </div>
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <p>We shall defend our island, whatever the cost may be, we shall fight on the beaches, we shall
                            fight on the landing grounds, we shall fight in the fields and in the streets, we shall fight in
                            the hills; we shall never surrender.</p>
                        <footer class="blockquote-footer">Winston Churchill</cite></footer>
                    </blockquote>
                </div>
            </div>
            <div class="card my-3">
                <div class="card-header">
                    How Are We Organised?
                </div>
                <div class="card-body">
                    <p class="card-text">
                    <p>In our system the Company leader is the leader over all of Apache. The Company is then comprised of
                        Platoon’s. There are seven Platoons, one to each starting hexagon, so in this case of current
                        event’s there will be as such:</p>

                    <ul>
                        <li>Fisherman’s Row Platoon</li>
                        <li>Westgate Platoon</li>
                        <li>The Heartlands Platoon</li>
                        <li>The Great March Platoon</li>
                        <li>Shackled Chasm Platoon</li>
                        <li>Allod’s Bight Platoon</li>
                        <li>Tempest Island Platoons</li>
                    </ul>

                    <p>Each platoon is comprised of 8 Squad’s. The seven squad will be as such:</p>

                    <ul>
                        <li>Armour</li>
                        <li>Infantry</li>
                        <li>Partisans</li>
                        <li>Artillery</li>
                        <li>Logistics</li>
                        <li>Engineering</li>
                        <li>Medics</li>
                        <li>Intelligence</li>
                    </ul>

                    <p>In each Squad there will be several Fireteam’s. The Fireteam will be comprised of 4 – 5 men.</p>

                    <p>Each section of hierarchy is adjustable in size, meaning that more Squad’s and more Fireteam’s can be
                        added as necessary.</p>

                    <p>Orders will be governed by the Company leader and passed down to the Platoon leader, which again will
                        be passed to the Squad leader. How the job is done will increase in complexity as the order travels
                        down the chain, that being the Squad leader having the most difficult job, since it would be him who
                        has to organise the overral push on the enemy.</p>

                    <p>The overall Company hierarchy is organised on a voting system, that being, that the Squad will vote
                        for their Squad leader, the squad leader’s will vote for their Platoon leader, and the Platoon
                        leader’s will vote for their Company leader. The point of this system is that the system will govern
                        itself so that the efficiency of Apache will continue through out the war.</p>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
