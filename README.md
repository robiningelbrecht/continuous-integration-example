<h1 align="center">CI/CD example</h1>

<p align="center">
	<img src="https://github.com/robiningelbrecht/continuous-integration-example/raw/master/readme/ci.png" alt="CI/CD">
</p>

<p align="center">
<a href="https://github.com/robiningelbrecht/continuous-integration-example/actions/workflows/ci-cd.yml"><img src="https://github.com/robiningelbrecht/continuous-integration-example/actions/workflows/ci-cd.yml/badge.svg" alt="CI/CD"></a>
<a href="https://codecov.io/gh/robiningelbrecht/continuous-integration-example"><img src="https://codecov.io/gh/robiningelbrecht/continuous-integration-example/branch/master/graph/badge.svg?token=9FEMHIZTZ0" alt="codecov.io"></a>
<a href="https://choosealicense.com/licenses/mit/"><img src="https://img.shields.io/github/license/robiningelbrecht/continuous-integration-example" alt="License"></a>
<a href="https://phpstan.org/"><img src="https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat" alt="PHPStan Enabled"></a>
<a href="https://php.net/"><img src="https://img.shields.io/packagist/php-v/robiningelbrecht/continuous-integration-example/dev-master" alt="PHP"></a>
</p>

------

This repository aims to build a fairly complete 
<a href="https://en.wikipedia.org/wiki/CI/CD" target="_blanks">CI/CD</a> 
example using GitHub workflows and actions.

Keep in mind that the toolset used in this repository is not the only solution 
to build a solid workflow. I'm sure there are many tools I have never heard of 
that can get the job done as wel 🚀.

If you liked this tutorial, please consider giving it a ⭐

__Note__: This tutorial won't explain the complete inner workings of GitHub 
workflows and actions, so some basic knowledge is required.

__Note 2__: Since I'm a PHP developer, all examples in this tutorial are PHP based.
It should be fairly easy to convert the workflows to be used with a "non PHP" code base.

------

<h2>Setting up the repository</h2>

Before we get into the technical stuff, we first need to set up our repository.
The main thing we want to do is setting up the _default branch_
and the _branch protection rules_. 

<h3>The default branch</h3>

The default branch is considered the “base” branch in your repository, 
against which all pull requests and code commits are automatically made, 
unless you specify a different branch. 

You can configure the default branch by navigating to 
https://github.com/username/repository/settings/branches. You can set the default 
branch to whatever you want, but usually "_main_" or "_master_" are used.

<h3>Branch protection rules</h3>

Branch protection rules allow you to disable force pushing, prevent branches from being deleted, 
and optionally require status checks before merging. These checks are important to ensure
code quality and have a solid CI/CD. For now, we will configure the bare minimum, 
but we will get back to this.

Navigate to https://github.com/username/repository/settings/branches and 
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

<h2>Configuring the CI/CD workflow</h2>

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

Let's take a closer look at all steps configured in this workflow.

For the unit tests to be able to run, we need to install PHP (deuh). Later on 
we'll need Xdebug as well to check and ensure code coverage.

```yaml
  - name: Setup PHP 8.1 with Xdebug 3.x
    uses: shivammathur/setup-php@v2
    with:
      php-version: '8.1'
      coverage: xdebug
```

The next step is to pull in the code and install all dependencies

```yaml
  - name: Checkout code
    uses: actions/checkout@v2

  - name: Install dependencies
    run: composer install --prefer-dist
```

TODO: screenshot of repo branch check settings.

<h3>Static code analysis & coding standards</h3>

<h2>Configuring the build & deploy workflow</h2>

<h3>Creating a build</h3>

<h3>Deploying to a remote server</h3>
https://github.com/marketplace/actions/ssh-remote-commands