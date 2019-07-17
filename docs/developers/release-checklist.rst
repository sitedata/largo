Release Checklist
=================

This document provides a reference implementation of a Largo release checklist, fulfulling the requirement set forth in `issue #809 <https://github.com/INN/largo/issues/809>`_ for a static copy of the release checklist.

Examples of the release checklist are:

- `0.6.1 <https://github.com/INN/largo/issues/1590>`_
- `0.6.2 <https://github.com/INN/largo/issues/1690>`_
- `0.6.3 <https://github.com/INN/largo/issues/1694>`_
- `0.6.4 <https://github.com/INN/largo/issues/1704>`_

Here's the reference list, in Markdown so that it can be copied into a new GitHub issue:::

    This is copied from `docs/developers/release-checklist.rst`, which is the reference issue for the pre-release checklist.

    The owner of the release needs to complete the following steps **BEFORE** merging to master and tagging the release:

    - [ ] run the [theme check plugin](https://wordpress.org/plugins/theme-check/) and address any outstanding issues. 
    - [ ] using [WP sample data](https://wpcom-themes.svn.automattic.com/demo/theme-unit-test-data.xml), go through the entire [theme unit tests checklist]
    - [ ] Update the INN Sandbox repo submodule https://github.com/INN/umbrella-innsandbox and take a look around http://demo.innsandbox.wpengine.com, making sure to test all testable items.
    - [ ] design checklist tktk (add to the list of theme unit tests, including style guidance, patterns that need to be followed, etc., eventually this will be codified in the INN/Largo style guide)
        - [ ] click around: don't just visually check the homepage, but also internal pages: https://github.com/INN/docs/blob/master/checklists/child-themes.md
        - [ ] Homepage `/`
            - [ ] Blog
            - [ ] Big Story, full-width image
            - [ ] Big story, list of featured stories
            - [ ] Big Story, list of stories from same series
            - [ ] Top Stories
            - [ ] Legacy Three Column
        - [ ] Articles `/?p=1234`
        - [ ] Series `/series/slug/` `/?series=1234`
        - [ ] Category archive pages `/category/slug/`
        - [ ] Series archive pages `/series/slug/`
        - [ ] Series landing pages `/slug/`
        - [ ] Search results `/?s=words`
        - [ ] Pages `/slug/`
        - [ ] Tag archives `/tag/slug`
        - [ ] Load More Posts
        - [ ] Sticky nav
            - [ ] Mobile
            - [ ] Desktop
        - [ ] Non-sticky nav
        - [ ] Widgets
            - [ ] Default background
            - [ ] Reverse Background
            - [ ] No Background
        - [ ] Article
            - [ ] Social buttons
            - [ ] Type
            - [ ] Fonts rendered are fonts specified in stylesheet ( In Chrome: "Inspect element" on a `<p>`, then look at the bottom of the "Computed" tab. )
            - [ ] Image display
            - [ ] slideshows, see https://github.com/INN/largo/issues/1664
        - [ ] Footer
    - [ ] check that the LESS Customizer works
    - [ ] test the plugins described in `docs/developers/plugin-compat.rst`
    - [ ] move any outstanding issues to future milestones or backlog
    - [ ] resolve all secret issues, private issues, or issues with the theme that are otherwise documented outside of this public repository
    - [ ] update the changelog
        - [ ] New features list
        - [ ] bugfixes
        - [ ] potentially breaking changes and upgrade notices
    - [ ] run `grunt build`
    - [ ] write release announcement
        - [ ] GitHub release drafted
            - can be copied from `changelog.md`
            - [ ] includes encouragement to say hi if you're using the theme. (This fulfills the "who's using our stuff?" goal in https://github.com/INN/largo/issues/1495)
        - [ ] labs.inn.org blog post written and saved as draft, based on changelog
    - [ ] update all version numbers. `0.6.4-prerelease.x` all become `0.6.4`.
    - [ ] merge 0.5-dev into 0.5

    Releasing:

    - [ ] tag and sign release `git tag -s v0.6.4`
    - [ ] publish the draft GitHub release at https://github.com/INN/largo/releases
    - [ ] close milestone

    After release is published:

    - [ ] publish launch announcement blog post
    - [ ] tweet announcement and schedule 2-5 for the next 7 days (TweetDeck, HootSuite) with simple download prompt or tweets detailing new features, like "Newsroom Staff Pages should be clean and useful. We think so too. See Largo 0.X's new...." Make sure these tweets get cross-tweeted between INN accounts.
    - [ ] recompile LESS on all child themes, and see https://github.com/INN/docs/blob/master/checklists/child-themes.md
    - [ ] new release needs to be deployed to our sites
        - inndev
        - innsandbox
        - inndevlearn
    - [ ] notify non-INN sites
    - [ ] update version number on largo.inn.org, like in INN/umbrella-inndev#36
    - [ ] bump version number in active-development branch to `0.6.5-prerelease`, as described inhttps://github.com/INN/largo/pull/1705
    - [ ] compare this ticket to the template used to create this ticket, and update the template
    - [ ] create the 0.6.5 release ticket from the template used to create this issue

After copying all that into a new ticket, be sure to update version numbers.
