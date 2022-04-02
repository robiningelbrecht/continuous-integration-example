<h1 align="center">CI/CD example</h1>

<p align="center">
	<img src="https://github.com/robiningelbrecht/continuous-integration-example/raw/master/readme/ci.png" alt="CI/CD">
</p>

<p align="center">
<a href="https://github.com/robiningelbrecht/continuous-integration-example/actions/workflows/ci.yml"><img src="https://github.com/robiningelbrecht/continuous-integration-example/actions/workflows/ci.yml/badge.svg" alt="CI/CD"></a>
<a href="https://codecov.io/gh/robiningelbrecht/continuous-integration-example"><img src="https://codecov.io/gh/robiningelbrecht/continuous-integration-example/branch/master/graph/badge.svg?token=9FEMHIZTZ0" alt="codecov.io"></a>
<a href="https://github.com/robiningelbrecht/continuous-integration-example/blob/master/LICENSE"><img src="https://img.shields.io/github/license/robiningelbrecht/continuous-integration-example?color=428f7e&logo=open%20source%20initiative&logoColor=white" alt="License"></a>
<a href="https://phpstan.org/"><img src="https://img.shields.io/badge/PHPStan-level%209-succes.svg?logo=php&logoColor=white&color=31C652" alt="PHPStan Enabled"></a>
<a href="https://php.net/"><img src="https://img.shields.io/packagist/php-v/robiningelbrecht/continuous-integration-example/dev-master?color=777bb3&logo=php&logoColor=white" alt="PHP"></a>
</p>

------

This repository aims to build a fairly complete 
<a href="https://en.wikipedia.org/wiki/CI/CD" target="_blanks">CI/CD</a> 
example using GitHub workflows and actions.

Keep in mind that the toolset used in this repository is not the only solution 
to build a solid workflow. I'm sure there are many tools I have never heard of 
that can get the job done as wel 💅.

If you liked this tutorial, please consider giving it a ⭐

__Note__: This tutorial won't explain the complete [inner workings](https://docs.github.com/en/actions/learn-github-actions/understanding-github-actions) of GitHub workflows and actions, so some basic knowledge is required. 

__Note 2__: Since I'm a PHP developer, all examples in this tutorial are PHP based.
It should be fairly easy to convert the workflows to be used with a "non PHP" code base.

------

<h2>🐣 Setting up the repository</h2>

Before we get into the technical stuff, we first need to set up our repository.
The main thing we want to do is setting up the _default branch_
and the _branch protection rules_. 

<h3>The default branch</h3>

The default branch is considered the “base” branch in your repository, 
against which all pull requests and code commits are automatically made, 
unless you specify a different branch. 

You can configure the default branch by navigating to 
`https://github.com/username/repository/settings/branches`. You can set the default 
branch to whatever you want, but usually "_main_" or "_master_" are used.

<h3>Branch protection rules</h3>

Branch protection rules allow you to disable force pushing, prevent branches from being deleted, 
and optionally require status checks before merging. These checks are important to ensure
code quality and have a solid CI. For now, we will configure the bare minimum, 
but we will get back to this.

Navigate to `https://github.com/username/repository/settings/branches` and 
add a new branch protection rule with following settings:

* Branch name pattern: _the name of your default branch_
* ✅ Require a pull request before merging
* ✅ Require approvals
* Required number of approvals before merging: _1_
* ✅ Require status checks to pass before merging
* ✅ Require branches to be up-to-date before merging

All other options should stay unchecked.

These rules will basically disable the ability to push to your default branch
and force you to work with pull requests and code reviews.

<h3>Configuring issue & PR templates</h3>

With [issue and pull request templates](https://docs.github.com/en/communities/using-templates-to-encourage-useful-issues-and-pull-requests/configuring-issue-templates-for-your-repository), 
you can customize and standardize the information you'd like contributors to include when 
they open issues and pull requests in your repository.

As this as not a required step to set up your workflows, it's always a good idea to 
standardize how users provide you with feedback about new features and bugs. It's up to 
you (and your team) to decide if you want to use this feature.

<h2>💎 Configuring the CI workflow</h2>

The next step is configuring the CI workflow. The [workflow](https://github.com/robiningelbrecht/continuous-integration-example/blob/master/.github/workflows/ci.yml) 
used in this example contains two jobs that __should__ ensure code quality. It is triggered
for all pull requests:

```yaml
on:
  pull_request:
  workflow_dispatch:
```

Since we configured that codes changes can only end up on the default branch via pull requests,
we are sure that the test suite will run for every new/changed line of code.

<h3>Running the test suite</h3>

Let's take a closer look at all steps configured in this job.

For the unit tests to be able to run, we need to install PHP (deuh). Later on 
we'll need Xdebug as well to check and ensure code coverage.

```yaml
  # https://github.com/marketplace/actions/setup-php-action
  - name: Setup PHP 8.1 with Xdebug 3.x
    uses: shivammathur/setup-php@v2
    with:
      php-version: '8.1'
      coverage: xdebug
```

<h4>🔥 PRO tip 🔥</h4>

If you want to run your test suite against multiple PHP versions and/or 
operating systems you can do this by using a [matrix setup](https://github.com/robiningelbrecht/continuous-integration-example/blob/master/.github/workflows/ci-cd-matrix.yml):

```yaml
  name: Test suite PHP ${{ matrix.php-versions }} on ${{ matrix.operating-system }}
  runs-on: ${{ matrix.operating-system }}
  strategy:
    matrix:
      operating-system: ['ubuntu-latest', 'ubuntu-18.04']
      php-versions: [ '7.4', '8.0', '8.1' ]
  steps:
    - name: Setup PHP ${{ matrix.php-versions }} with Xdebug 3.x
      uses: shivammathur/setup-php@v2
      with:
        php-version: ${{ matrix.php-versions }}
        coverage: xdebug
```

This should result in a workflow run for all possible combinations in the matrix:

<p align="center">
	<img src="https://github.com/robiningelbrecht/continuous-integration-example/raw/master/readme/ci-matrix.png" alt="CI matrix" width="250">
</p>

The next step is to pull in the code and install all dependencies

```yaml
  # https://github.com/marketplace/actions/checkout
  - name: Checkout code
    uses: actions/checkout@v2

  - name: Install dependencies
    run: composer install --prefer-dist
```

After which the tests can finally run

```yaml
  - name: Run test suite
    run: vendor/bin/phpunit --testsuite unit --fail-on-incomplete  --log-junit junit.xml --coverage-clover clover.xml
```

You probably noticed that the command to run the test contains some options.
Each of them have a purpose:

* __--fail-on-incomplete__: forces PHPUnit to fail on incomplete tests
* __--log-junit junit.xml__: generates an XML file to publish the test results later on
* __--coverage-clover clover.xml__: generates an XML file to check the test coverage later on

After running the tests, we can visualize and publish them as a comment on the pull request.

```yaml
  # https://github.com/marketplace/actions/publish-unit-test-results
  - name: Publish test results
    uses: EnricoMi/publish-unit-test-result-action@v1.31
    if: always()
    with:
      files: "junit.xml"
      check_name: "Unit test results"
```

<p align="center">
	<img src="https://github.com/robiningelbrecht/continuous-integration-example/raw/master/readme/unit-test-results.png" alt="Unit test results" width="500">
</p>

We'll also send the generated `clover.xml` report to [codecov.io](https://about.codecov.io/)

> Codecov gives companies actionable coverage insights when and where 
> they need them to ensure they are shipping quality code.

Codecov.io basically allows you to check your code coverage and find untested code.
It does so by providing [fancy graphs and charts](https://app.codecov.io/gh/robiningelbrecht/continuous-integration-example).

```yaml
  # https://github.com/marketplace/actions/codecov
  - name: Send test coverage to codecov.io
    uses: codecov/codecov-action@v2.1.0
    with:
      files: clover.xml
      fail_ci_if_error: true # optional (default = false)
      verbose: true # optional (default = false)
```

The codecov action also adds a comment on each pull request.
<p align="center">
	<img src="https://github.com/robiningelbrecht/continuous-integration-example/raw/master/readme/codecov-results.png" alt="Codecov.io results" width="500">
</p>

Last but not least we ensure a minimum test coverage of 90% across the project. 
If the minimum coverage isn't reached, the job will fail.
This is done using [this test coverage checker](https://github.com/robiningelbrecht/phpunit-coverage-check).

```yaml
  - name: Check minimum required test coverage
    run: |
      CODE_COVERAGE=$(vendor/bin/coverage-checker clover.xml 90 --processor=clover-coverage)
      echo ${CODE_COVERAGE}
      if [[ ${CODE_COVERAGE} == *"test coverage, got"* ]] ; then
        exit 1;
      fi
```

<h3>Static code analysis & coding standards</h3>

Running static code analysis and applying coding standards are configured in a separate job
because these don't need Xdebug or other fancy dependencies.

To run these tasks we'll use [PHPStan](https://phpstan.org/) 
and [PHP Coding Standards Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer)

> PHPStan focuses on finding errors in your code without actually running it. 
> It catches whole classes of bugs even before you write tests for the code.

> The PHP Coding Standards Fixer (PHP CS Fixer) tool fixes your code to follow standards; 
> whether you want to follow PHP coding standards as defined in the PSR-1, PSR-2, etc., 
> or other community driven ones like the Symfony one.

Once again we need to install PHP, checkout the code and install dependencies

```yaml
  # https://github.com/marketplace/actions/setup-php-action
  - name: Setup PHP 8.1
    uses: shivammathur/setup-php@v2
    with:
      php-version: '8.1'

  # https://github.com/marketplace/actions/checkout
  - name: Checkout code
    uses: actions/checkout@v2
    
  - name: Install dependencies
    run: composer install --prefer-dist
```

After which we run the static code analyser

```yaml
  - name: Run PHPStan
    run: vendor/bin/phpstan analyse
```

And check coding standards

```yaml
  - name: Run PHPcs fixer dry-run
    run: vendor/bin/php-cs-fixer fix --dry-run --stop-on-violation --config=.php-cs-fixer.dist.php
```

The job will fail if one of both tasks does not succeed.

Now that the CI workflow has been configured, we can go back to the 
repository branch protection rules and tighten them up by configuring extra 
required status checks:

<p align="center">
	<img src="https://github.com/robiningelbrecht/continuous-integration-example/raw/master/readme/protected-branch-settings.png" alt="Protected branch settings" width="500">
</p>

These settings require both jobs in the CI workflow to succeed before the PR can be merged.

<h3>Example pull requests</h3>

There are some example pull requests to show the different reasons why a PR
can fail and what it takes for one to pass.

* ❌ [Failed PR because of PHPStan](https://github.com/robiningelbrecht/continuous-integration-example/pull/3)
* ❌ [Failed PR because of PHP coding standards](https://github.com/robiningelbrecht/continuous-integration-example/pull/4)
* ❌ [Failed PR because of UnitTest](https://github.com/robiningelbrecht/continuous-integration-example/pull/5)
* ❌ [Failed PR because of low test coverage](https://github.com/robiningelbrecht/continuous-integration-example/pull/6)
* ✅ [A successful pull request](https://github.com/robiningelbrecht/continuous-integration-example/pull/7)

<h2>🚀 Configuring the build & deploy workflow</h2>

At this point new features and bug fixes can be "safely" merged to the main branch,
but they still need to be deployed to a remote server. The [workflow](https://github.com/robiningelbrecht/continuous-integration-example/blob/master/.github/workflows/build-deploy.yml)
used in this example contains two jobs that take care of the deploy. It will be triggered manually:

```yaml
  on:
    workflow_dispatch:
```

<h3>Creating a build</h3>

We'll start of with creating a build by using artifacts. Before starting, we first need
to check if the selected branch is allowed to be deployed:

```yaml
  build:
    if: github.ref_name == 'master' || github.ref_name == 'development'
    name: Create build ${{ github.run_number }} for ${{ github.ref_name }}
```

If any other branch than `master` or `development` is selected the workflow will be aborted.

To create the build with the necessary files we first have to pull the dependencies again

```yaml
  # https://github.com/marketplace/actions/checkout
  - name: Checkout code
    uses: actions/checkout@v2

  # https://github.com/marketplace/actions/setup-php-action
  - name: Setup PHP 8.1
    uses: shivammathur/setup-php@v2
    with:
      php-version: '8.1'

  - name: Install dependencies
    run: composer install --prefer-dist --no-dev
```

After which we can create an artifact that contains the files needed for a deploy.

```yaml
  # https://github.com/marketplace/actions/upload-a-build-artifact
  - name: Create artifact
    uses: actions/upload-artifact@v3
    with:
      name: release-${{ github.run_number }}
      path: |
        src/**
        vendor/**
```

All artifacts created during a workflow can be downloaded from the workflow summary page.
This can come in handy to "debug" your artifact and to check which files are actually included.

<p align="center">
	<img src="https://github.com/robiningelbrecht/continuous-integration-example/raw/master/readme/artifacts.png" alt="Artifacts" width="500">
</p>

<h3>Deploying to a remote server</h3>

The next and final step is to deploy the build we created in the previous step. 
Before we can do this, we first need to configure an [environment](https://docs.github.com/en/actions/deployment/targeting-different-environments/using-environments-for-deployment). 

Navigate to `https://github.com/username/repository/settings/environments` to do this.
In this example we'll have an environment for `master` and `development` 
on which we'll configure the following: 

<p align="center">
	<img src="https://github.com/robiningelbrecht/continuous-integration-example/raw/master/readme/environment-settings.png" alt="Environment settings" width="500">
</p>

These settings will enforce that only the `development` branch can be deployed 
to the development environment. The secrets configured on the environment will be used
to connect to the remote server during deploy.

Now we're ready to start configuring the deploy job. We start off by

* Referencing the build step. We cannot deploy before the build has been finished.
* Referencing the environment we are deploying. This will
  1. allow us to use the secrets configured on that environment
  2. allow GitHub to validate that the correct branch is deployed to that environment 
  3. allow GitHub to indicate if a PR has been deployed (or not):

<p align="center">
	<img src="https://github.com/robiningelbrecht/continuous-integration-example/raw/master/readme/branch-deploy-info.png" alt="Branch deploy info">
</p>

FYI: `${{ github.ref_name }}` contains the branch or tag the workflow is initialised with.

```yaml
  needs: build
  environment:
    name: ${{ github.ref_name }}
    url: https://${{ github.ref_name }}.env
```

By setting the `concurrency` we make sure only one deploy (per environment) at a time can be run.

```yaml
  concurrency: ${{ github.ref_name }}
```

The first step in this job will download the artifact we created in the previous job.
It contains all the files that need to be transferred to the remote server.

```yaml
  # https://github.com/marketplace/actions/download-a-build-artifact
  - name: Download artifact
    uses: actions/download-artifact@v3
    with:
      name: release-${{ github.run_number }}
```

Next we'll use `rsync` to transfer al downloaded file to the server. This step uses 
the secrets we have configured on our repository's [environments](https://docs.github.com/en/actions/deployment/targeting-different-environments/using-environments-for-deployment)
to authenticate.

```yaml
  # https://github.com/marketplace/actions/rsync-deployments-action
  - name: Rsync build to server
    uses: burnett01/rsync-deployments@5.2
    with:
      switches: -avzr --delete
      path: .
      remote_path: /var/www/release-${{ github.run_number }}/
      remote_host: ${{ secrets.SSH_HOST }}
      remote_user: ${{ secrets.SSH_USERNAME }}
      remote_key: ${{ secrets.SSH_KEY }}
```

Once the files have been transferred, the last thing we need to do is run a deploy script.
This script can do a number of things depending on the stack you are using. In this example
we'll run some database updates and install a new crontab.

```yaml
  # https://github.com/marketplace/actions/ssh-remote-commands
  - name: Run remote SSH commands
    uses: appleboy/ssh-action@master
    with:
      host: ${{ secrets.HOST }}
      username: ${{ secrets.USERNAME }}
      key: ${{ secrets.KEY }}
      port: ${{ secrets.PORT }}
      script: |
        RELEASE_DIRECTORY=/var/www/release-${{ github.run_number }}
        CURRENT_DIRECTORY=/var/www/app
        
        # Remove symlink.
        rm -r "${CURRENT_DIRECTORY}"
        
        # Create symlink to new release.
        ls -s "${RELEASE_DIRECTORY}" "${CURRENT_DIRECTORY}"
        
        # Run database migrations
        ${CURRENT_DIRECTORY}/bin/console doctrine:migrations:migrate
        
        # Install updated crontab
        crontab ${RELEASE_DIRECTORY}/crontab
        
        # Clear cache
        ${CURRENT_DIRECTORY}/bin/console cache:clear
```

At this point new features and/or bug fixes are deployed to your remote server. You should be 
good to go to repeat this cycle over and over and over again 😌

<h2>🍔 Hungry for more?</h2>

This example touches only a few aspects of continuous integration and continuous development.
There are lots of extra things I could have covered, but I wanted to keep this clean and simple.

<h3>Integration tests</h3>

> Integration testing is the phase in software testing in which individual software modules 
are combined and tested as a group. 

There are multiple frameworks out there that provide
a toolset to implement your integration tests, [codeception](https://codeception.com/) is one of them.

<h3>End-to-end tests</h3>

> End-to-end testing is a technique that tests the entire software product from beginning 
to end to ensure the application flow behaves as expected.

[https://codecept.io/](https://codecept.io/) is one of many tools that provde a e2e testing framework.

<h3>Visual regression tests</h3>

> A visual regression test checks what the user will see after any code changes have 
been executed by comparing screenshots taken before and after deploys. 

[BackstopJS](https://github.com/garris/BackstopJS) is an open-source tool that allows 
you to implement such checks.

<h3>Auto deploy on merging</h3>

This example handles deploys as a manual action, but it's possible to automate this.
Let's assume you want to deploy every time something is merged, you can configure your 
workflow to be triggered as following:

```yaml
  on:
    push:
      branches:
        - master
        - develop
```

<h3>Speed up your test suite</h3>

As your application and thus test suite grows, your workflows will take longer and longer 
to complete. There are several nifty tricks to speed up you test suite:

* Use [Paratest](https://github.com/paratestphp/paratest) to run test in parallel
* [Cache](https://docs.github.com/en/actions/using-workflows/caching-dependencies-to-speed-up-workflows) your vendor dependencies
* Use an in-memory SQLite database for tests that hit your database
* Disable Xdebug, if you don't need test coverage

<h3>Composite actions</h3>

[Composite actions](https://docs.github.com/en/actions/creating-actions/creating-a-composite-action)
can be used to split workflows into smaller, reusable components. I could tell you all
about them, but [this blogpost](https://dev.to/jameswallis/using-github-composite-actions-to-make-your-workflows-smaller-and-more-reusable-476l) 
does a perfect job at explaining how to define and use them. Big up to the author James Wallis 👌

<h2>🌈 Feedback and questions</h2>

As I stated in the beginning, this is only one approach on how you could set up your CI/CD and
deploy flow. It's just an example to get you going. If you have any feedback or suggestions to 
improve this tutorial, please let me know. I'm always open to learning new approaches and 
getting to know new tools.

If you have any questions, feel free to 📭 [contact me](https://www.linkedin.com/in/robin-ingelbrecht/), 
I'll be glad to help you out.
