<h1 align="center">CI/CD example</h1>

<p align="center">
	<img src="https://github.com/robiningelbrecht/continuous-integration-example/raw/master/readme/ci.png" alt="CI/CD">
</p>

<p align="center">
<a href="https://github.com/robiningelbrecht/continuous-integration-example/actions/workflows/ci-cd.yml"><img src="https://github.com/robiningelbrecht/continuous-integration-example/actions/workflows/ci-cd.yml/badge.svg" alt="CI/CD"></a>
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

__Note__: This tutorial won't explain the complete inner workings of GitHub 
workflows and actions, so some basic knowledge is required.

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
code quality and have a solid CI/CD. For now, we will configure the bare minimum, 
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

<h2>💎 Configuring the CI/CD workflow</h2>

The next step is configuring the CI/CD workflow. The [workflow](https://github.com/robiningelbrecht/continuous-integration-example/blob/master/.github/workflows/ci-cd.yml) 
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

<h4>🌟PRO tip🌟</h4>

If you want to run your test suite against different PHP versions 
and/or operating systems you can do this by using a matrix setup:

```yaml
  runs-on: ${{ matrix.operating-system }}
  strategy:
    matrix:
      operating-system: ['ubuntu-latest', 'windows-latest', 'macos-latest']
      php-versions: [ '7.4', '8.0', '8.1' ]
  name: Test suite PHP ${{ matrix.php-versions }} on ${{ matrix.operating-system }}
  steps:
    - name: Setup PHP with Xdebug 3.x
      uses: shivammathur/setup-php@v2
      with:
        php-version: ${{ matrix.php-versions }}
        coverage: xdebug
```

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

Last but not least we ensure a minimum code coverage of 90% across the project. 
If the minimum coverage isn't reached, the job will fail.
This is done using [this code coverage checker](https://github.com/robiningelbrecht/phpunit-coverage-check).

```yaml
  - name: Check minimum required code coverage
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

Now that the CI/CD workflow has been configured, we can go back to the 
repository branch protection rules and tighten them up by configuring extra 
required status checks:

<p align="center">
	<img src="https://github.com/robiningelbrecht/continuous-integration-example/raw/master/readme/protected-branch-settings.png" alt="Protected branch settings" width="500">
</p>

These settings require both jobs in the CI/CD workflow to succeed before the PR can be merged.

<h3>Example pull requests</h3>

* [Failing PR because of PHPStan](https://github.com/robiningelbrecht/continuous-integration-example/pull/3)
* TODO: link to more examples of (failed) PRs.

<h2>🚀 Configuring the build & deploy workflow</h2>

<h3>Creating a build</h3>

<h3>Deploying to a remote server</h3>

@TODO:
- Auto deploy:

```yaml
  push:
    branches:
      - master
      - develop
```

- Parallel testing: https://github.com/paratestphp/paratest
- Issue templates: https://docs.github.com/en/communities/using-templates-to-encourage-useful-issues-and-pull-requests/configuring-issue-templates-for-your-repository
