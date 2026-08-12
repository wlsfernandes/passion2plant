# Passion2Plant Design System

## Purpose

This document defines the visual design rules for the Passion2Plant website and admin-managed frontend content.

The goal is to preserve a professional, warm, faith-rooted visual identity while keeping the existing website structure stable, consistent, accessible, and easy to maintain.

This document should be used as the default design reference for future frontend, Blade, SCSS/CSS, CKEditor, theme-settings, and page-component work unless a project requirement explicitly states otherwise.

---

## Base Template Reference

The current Passion2Plant website is based on:

**GreenEarth - Tree Plantation, Environmental Ecology Responsive HTML Template**  
TemplateMonster reference:  
https://www.templatemonster.com/website-templates/greenearth-tree-plantation-environmental-ecology-responsive-html-template-371721.html

The GreenEarth template remains the structural and component reference for the website.

When modifying or creating frontend sections:

- Preserve the existing GreenEarth layout language.
- Reuse existing template components, spacing patterns, responsive behavior, section structures, buttons, cards, navigation patterns, and footer/header conventions whenever practical.
- Prefer adapting an existing GreenEarth component over introducing a completely different visual pattern.
- Do not redesign the website into a different visual system unless explicitly requested.
- New branding should be layered onto the existing template rather than replacing its fundamental structure.
- Preserve responsive behavior across desktop, tablet, and mobile.
- Avoid unnecessary frontend frameworks or component libraries that visually conflict with the existing template.

---

## Design Philosophy

Passion2Plant should feel:

- Warm
- Professional
- Grounded
- Contemporary
- Purposeful
- Ministry-oriented
- Culturally aware
- Clear and credible

The design should communicate energy and growth without becoming playful, childish, overly decorative, or visually noisy.

Use generous whitespace and clear visual hierarchy.

Allow the brand colors to bring warmth and personality while keeping layouts disciplined and readable.

The website should feel established and trustworthy rather than trendy for the sake of being trendy.

---

## Brand Palette

### Passion Coral

`#E05E4E`

Primary role:

- Energy
- Invitation
- Action
- Selected accents
- Important highlights

Use intentionally. Do not apply Coral to every interactive element simply because it is a brand color.

---

### Plant Gold

`#EEA53F`

Primary role:

- Highlights
- Opportunity
- Celebration
- Small accents
- Icons
- Badges
- Selected emphasis

Gold should normally be an accent rather than a dominant page background.

---

### Rooted Olive

`#938A42`

Primary role:

- Primary website theme color
- Formation
- Wisdom
- Grounded visual identity
- Main brand accents
- Existing theme-color replacement

For the current Passion2Plant implementation, **Rooted Olive is the preferred primary theme color** unless otherwise approved.

Theme mapping:

```css
--brand-primary: #938A42;
```

---

### Soil Brown

`#6A3C2D`

Primary role:

- Grounding
- Heritage
- Secondary dark accent
- Selected hover states
- Supporting visual elements

Use selectively. It should support the palette rather than dominate the interface.

---

### Canopy Black

`#0E1911`

Primary role:

- Headings
- Strong body text
- Dark backgrounds
- High-contrast calls to action
- Navigation text when a dark-text mode is appropriate

Theme mapping:

```css
--brand-dark: #0E1911;
```

---

### Sprout Cream

`#FFF8EE`

Primary role:

- Warm backgrounds
- Light sections
- Content breathing room
- Alternative to pure white

Theme mapping:

```css
--brand-light: #FFF8EE;
```

---

## Recommended Theme Mapping

Use semantic theme variables instead of placing brand hex values throughout component CSS.

```css
:root {
    --brand-primary: #938A42;
    --brand-secondary: #E05E4E;
    --brand-accent: #EEA53F;
    --brand-dark: #0E1911;
    --brand-light: #FFF8EE;
    --brand-body: #FFFFFF;
}
```

Compatibility with the existing GreenEarth theme may map these values onto existing variables:

```css
--theme-color: var(--brand-primary);
--black-color: var(--brand-dark);
--title-color: var(--brand-dark);
--section-color: var(--brand-light);
--body: var(--brand-body);
--ratting-color: var(--brand-accent);
```

Do not globally rename or refactor legacy theme variables without a specific technical reason.

---

## Color Hierarchy

The brand palette should have defined roles.

Preferred hierarchy:

1. **Rooted Olive** — primary site theme
2. **Passion Coral** — secondary/accent emphasis
3. **Plant Gold** — highlight/accent
4. **Canopy Black** — headings, text, strong contrast
5. **Sprout Cream** — light backgrounds
6. **Soil Brown** — supporting grounded accent

Do not attempt to use all six colors equally on every page.

Consistency is more important than maximizing color variety.

---

## Contrast and Readability

Readability always takes priority over decorative color use.

Use dark text on light or warm backgrounds when possible.

Recommended combinations include:

- Canopy Black on Sprout Cream
- Canopy Black on white
- Canopy Black on Rooted Olive when contrast remains appropriate for the intended text size
- Sprout Cream on Canopy Black
- Sprout Cream on Soil Brown

Be cautious with light text over Passion Coral, Plant Gold, or Rooted Olive.

Do not assume white text is readable simply because a background is colored.

For navigation and other global components, use controlled contrast modes rather than allowing arbitrary text colors.

Example:

```css
--header-menu-text-color: var(--white-color);
```

or:

```css
--header-menu-text-color: var(--brand-dark);
```

---

## Typography

The approved Passion2Plant typography system uses:

### DM Serif Display

Use for:

- Major storytelling headings
- Campaign titles
- Short quotations
- Selected hero statements
- Short theological or mission-focused statements

Do not use DM Serif Display for long body copy.

Recommended CSS stack:

```css
font-family: "DM Serif Display", Georgia, serif;
```

---

### Montserrat

Use for:

- Headings
- Navigation
- Buttons
- Calls to action
- Labels
- Short digital text
- Interface elements

Recommended weights:

- 400 Regular
- 500 Medium
- 600 SemiBold
- 700 Bold

Recommended CSS stack:

```css
font-family: "Montserrat", Arial, Helvetica, sans-serif;
```

---

### Source Sans 3

Use for:

- Body copy
- Longer articles
- Guides
- Educational content
- Resource pages
- Long-form reading

Recommended CSS stack:

```css
font-family: "Source Sans 3", Arial, Helvetica, sans-serif;
```

---

## Theme Typography Strategy

The existing GreenEarth typography remains the fallback unless a custom theme font is enabled.

Preferred configurable roles:

```css
--theme-body-font
--theme-heading-font
```

Do not hardcode administrator-selected fonts directly into component CSS.

Example:

```css
body {
    font-family: var(--theme-body-font, "Existing Theme Font", sans-serif);
}
```

```css
h1,
h2,
h3,
h4,
h5,
h6 {
    font-family: var(--theme-heading-font, "Existing Theme Heading Font", sans-serif);
}
```

The exact fallback should match the existing GreenEarth implementation in the project.

---

## Admin Theme Settings

The administration panel may expose controlled theme settings.

Approved configurable fields:

- Primary color
- Secondary color
- Accent color
- Dark color
- Light/section color
- Body/background color
- Header text contrast: Light or Dark
- Body font
- Heading font

Do not expose raw CSS editing to normal administrators.

Do not allow arbitrary font URLs or arbitrary CSS values.

All theme values must be validated and mapped into controlled CSS variables.

The original theme must always remain available as a safe fallback.

---

## Page Editor / CKEditor

The page editor should make the approved Passion2Plant colors available to content editors.

Approved brand colors:

- Passion Coral — `#E05E4E`
- Plant Gold — `#EEA53F`
- Rooted Olive — `#938A42`
- Soil Brown — `#6A3C2D`
- Canopy Black — `#0E1911`
- Sprout Cream — `#FFF8EE`

Approved brand fonts:

- Montserrat
- DM Serif Display
- Source Sans 3

The editor may also retain standard utility colors and fallback fonts where useful.

Content editors should be able to use the brand palette without manually entering hex codes.

Do not assume that page-editor styling controls the global website theme. Global components such as the header, footer, navigation, buttons, and shared sections remain theme-level concerns.

---

## Headers and Navigation

Preserve the existing GreenEarth header structure unless explicitly redesigning it.

Navigation should remain:

- Easy to scan
- High contrast
- Responsive
- Visually restrained
- Consistent with the existing template

Use either light or dark navigation text depending on the selected header/background combination.

Do not introduce decorative typefaces into main navigation.

Do not use multiple competing accent colors in the same navigation area.

---

## Buttons and Calls to Action

Buttons should follow existing GreenEarth component structure and dimensions whenever possible.

Primary actions should use one clearly dominant treatment.

Recommended roles:

- Rooted Olive for primary theme actions
- Passion Coral for selected accent or campaign actions
- Plant Gold for limited highlights
- Canopy Black for strong high-contrast calls to action where appropriate

Do not use all brand colors as competing button styles on the same page.

Hover states should remain clear and accessible.

Avoid excessive animation.

---

## Sections and Backgrounds

Preferred backgrounds:

- White
- Sprout Cream
- Existing GreenEarth neutral/light backgrounds
- Canopy Black for intentionally dark sections

Use colored backgrounds strategically.

Do not alternate through every brand color simply to introduce visual variety.

Preserve generous spacing between sections.

New sections should generally follow the existing GreenEarth spacing and container widths.

---

## Cards

Cards should remain consistent with the GreenEarth visual system.

Prefer:

- Clean backgrounds
- Strong headings
- Restrained borders
- Moderate radius
- Clear image hierarchy
- Minimal shadow

Avoid excessive elevation effects or highly rounded mobile-app-style cards unless already part of an existing template component.

---

## Images

Preferred imagery should feel:

- Authentic
- Human
- Ministry-centered
- Warm
- Purposeful
- Community-oriented
- Naturally lit

Prefer real people and real ministry/community activity over generic corporate stock photography when quality assets are available.

Do not apply heavy filters merely to force photographs into the brand palette.

---

## Spacing

Use generous whitespace.

Follow the GreenEarth template's established:

- Container widths
- Section padding
- Grid gaps
- Heading spacing
- Card spacing
- Responsive breakpoints

Do not compress sections merely to fit more information above the fold.

---

## Responsive Design

All design changes must preserve the GreenEarth responsive behavior.

Always consider:

- Desktop
- Tablet
- Mobile navigation
- Button wrapping
- Heading length
- Image cropping
- Editor-generated content
- Tables and embeds

Do not introduce fixed widths that break the existing responsive system.

---

## Accessibility

Design decisions should prioritize:

- Clear text/background contrast
- Readable font sizes
- Visible focus states
- Understandable link and button states
- Consistent heading hierarchy
- Sufficient spacing around interactive controls

Color must not be the only way information is communicated.

Avoid low-contrast decorative text.

---

## Visual Tone

Passion2Plant should feel professional and established.

Use:

- Warm neutrals
- Strong typography
- Purposeful imagery
- Controlled color accents
- Natural visual rhythm
- Clear hierarchy
- Generous space

Avoid:

- Overly playful compositions
- Cartoon-like presentation
- Excessive decorative shapes
- Visually crowded sections
- Trend-heavy layouts that conflict with GreenEarth
- Excessive gradients
- Excessive drop shadows
- Excessive animations

---

## Do Not Use

- No neon colors
- No arbitrary colors outside the approved palette without a clear functional reason
- No decorative fonts for body text
- No uncontrolled font uploads
- No arbitrary Google Fonts URLs supplied by administrators
- No excessive gradients
- No heavy or repeated drop shadows
- No excessive animation
- No multiple competing primary colors
- No border radius larger than 16px unless an existing GreenEarth component specifically requires it
- No visual changes that break the GreenEarth responsive structure
- No new UI library solely to achieve a different aesthetic
- No redesign of global components without explicit approval
- No hardcoded brand colors when an appropriate semantic CSS variable already exists

---

## Implementation Preference

When adding or modifying frontend styles, prefer this order:

1. Reuse an existing GreenEarth component.
2. Apply approved semantic theme variables.
3. Add a small project-owned SCSS/CSS override when necessary.
4. Extend the component carefully if the template cannot support the requirement.
5. Avoid rewriting stable template code unnecessarily.

Changes should be surgical and maintainable.

---

## Design Decision Rule

Before introducing a new visual treatment, ask:

1. Does GreenEarth already contain a component that solves this?
2. Is the treatment consistent with the Passion2Plant palette and typography?
3. Does it preserve accessibility and responsive behavior?
4. Is the change necessary, or is it purely decorative?
5. Can it be accomplished by adjusting existing theme variables instead of rewriting the component?

If an existing template pattern works, prefer it.

---

## Current Brand Defaults

Unless explicitly changed through approved Theme Settings, use:

```text
Primary:        Rooted Olive  #938A42
Secondary:      Passion Coral #E05E4E
Accent:         Plant Gold    #EEA53F
Dark:           Canopy Black  #0E1911
Light:          Sprout Cream  #FFF8EE
Body Background: White        #FFFFFF
```

Recommended typography direction:

```text
Display / Storytelling: DM Serif Display
Digital / UI / CTA:     Montserrat
Long-form Content:      Source Sans 3
```

---

## Final Principle

**Preserve the GreenEarth template structure. Apply the Passion2Plant brand through controlled colors, typography, and semantic theme settings—not through unnecessary redesign.**

The result should feel like a professionally branded evolution of the existing website, not a different template layered on top of it.