#!/bin/bash

if [ $TRAVIS_BRANCH == 'master' ] ; then
    git remote add deploy "deploy@katy-ereira.co.uk:/var/repo/activity-monitor.git"
    git push --force deploy $TRAVIS_BRANCH
else
    echo "Not deploying, since this branch isn't master."
fi