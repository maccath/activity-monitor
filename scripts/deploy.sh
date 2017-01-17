#!/bin/bash
set -x
#if [ $TRAVIS_BRANCH == 'master' ] ; then
    # Initialize a new git repo in _site, and push it to our server.
    cd _site
    git init

    git remote add deploy "deploy@138.68.172.224:/var/www/Sites/activity-monitor"
    git config user.name "Travis CI"
    git config user.email "katy.ereira+travisCI@gmail.com"

    git add .
    git commit -m "Deploy"
    git push --force deploy master
#else
#    echo "Not deploying, since this branch isn't master."
#fi