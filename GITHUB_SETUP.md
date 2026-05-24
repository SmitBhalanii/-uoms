# GitHub Setup Guide for UOMS

## Prerequisites

Before pushing to GitHub, ensure you have:

1. ✅ Git installed on your system
2. ✅ GitHub account created
3. ✅ Git configured with your name and email

---

## Step 1: Configure Git (First Time Only)

```bash
# Set your name
git config --global user.name "Your Name"

# Set your email (use your GitHub email)
git config --global user.email "your.email@example.com"

# Verify configuration
git config --global --list
```

---

## Step 2: Create GitHub Repository

### Option A: Via GitHub Website (Recommended)

1. Go to https://github.com
2. Click the **"+"** icon in top-right corner
3. Select **"New repository"**
4. Fill in details:
   - **Repository name**: `uoms` or `university-order-management-system`
   - **Description**: `University Order Management System - Laravel 12 with Role-Based Authentication`
   - **Visibility**: Choose Public or Private
   - **DO NOT** initialize with README, .gitignore, or license (we already have these)
5. Click **"Create repository"**

### Option B: Via GitHub CLI (if installed)

```bash
gh repo create uoms --public --description "University Order Management System"
```

---

## Step 3: Initialize Git in Project

```bash
# Navigate to project directory
cd uoms

# Initialize git repository
git init

# Check status
git status
```

---

## Step 4: Create .gitignore (Already exists, but verify)

The Laravel project already has a `.gitignore` file. Verify it includes:

```
/node_modules
/public/hot
/public/storage
/storage/*.key
/vendor
.env
.env.backup
.phpunit.result.cache
Homestead.json
Homestead.yaml
npm-debug.log
yarn-error.log
```

---

## Step 5: Stage and Commit Files

```bash
# Add all files to staging
git add .

# Check what will be committed
git status

# Create initial commit
git commit -m "Initial commit: UOMS Laravel 12 project with role-based authentication"
```

---

## Step 6: Connect to GitHub Repository

After creating the repository on GitHub, you'll see a URL like:
- HTTPS: `https://github.com/yourusername/uoms.git`
- SSH: `git@github.com:yourusername/uoms.git`

### Using HTTPS (Easier for beginners)

```bash
# Add remote repository
git remote add origin https://github.com/yourusername/uoms.git

# Verify remote
git remote -v
```

### Using SSH (More secure, requires SSH key setup)

```bash
# Add remote repository
git remote add origin git@github.com:yourusername/uoms.git

# Verify remote
git remote -v
```

---

## Step 7: Push to GitHub

```bash
# Push to main branch
git push -u origin main

# If you get an error about 'master' branch, use:
git branch -M main
git push -u origin main
```

---

## Step 8: Verify on GitHub

1. Go to your repository URL: `https://github.com/yourusername/uoms`
2. You should see all your files
3. Check that README.md is displayed

---

## Authentication Methods

### Method 1: Personal Access Token (Recommended for HTTPS)

If using HTTPS and prompted for password:

1. Go to GitHub → Settings → Developer settings → Personal access tokens → Tokens (classic)
2. Click "Generate new token (classic)"
3. Give it a name: "UOMS Project"
4. Select scopes: `repo` (full control of private repositories)
5. Click "Generate token"
6. **Copy the token** (you won't see it again!)
7. When Git asks for password, paste the token instead

### Method 2: SSH Key (Recommended for advanced users)

```bash
# Generate SSH key
ssh-keygen -t ed25519 -C "your.email@example.com"

# Start SSH agent
eval "$(ssh-agent -s)"

# Add SSH key
ssh-add ~/.ssh/id_ed25519

# Copy public key
cat ~/.ssh/id_ed25519.pub

# Add to GitHub:
# GitHub → Settings → SSH and GPG keys → New SSH key
# Paste the public key
```

---

## Common Git Commands for Future Use

### Daily Workflow

```bash
# Check status
git status

# Add specific file
git add filename.php

# Add all changes
git add .

# Commit changes
git commit -m "Description of changes"

# Push to GitHub
git push

# Pull latest changes
git pull
```

### Branching

```bash
# Create new branch
git checkout -b feature/new-feature

# Switch branch
git checkout main

# List branches
git branch

# Merge branch
git checkout main
git merge feature/new-feature

# Delete branch
git branch -d feature/new-feature
```

### Viewing History

```bash
# View commit history
git log

# View compact history
git log --oneline

# View changes
git diff
```

---

## Recommended .gitignore Additions

Add these to `.gitignore` if not already present:

```
# IDE
.idea/
.vscode/
*.swp
*.swo
*~

# OS
.DS_Store
Thumbs.db

# Laravel specific
/public/build
/public/hot
/storage/*.key
/vendor
.env
.env.backup
.phpunit.result.cache
Homestead.json
Homestead.yaml
npm-debug.log
yarn-error.log

# Node
node_modules/
npm-debug.log*
yarn-debug.log*
yarn-error.log*

# Database
*.sqlite
*.sqlite-journal
database/database.sqlite
```

---

## Create a Professional README.md for GitHub

I'll create a separate README.md optimized for GitHub display.

---

## Troubleshooting

### Error: "remote origin already exists"

```bash
# Remove existing remote
git remote remove origin

# Add new remote
git remote add origin https://github.com/yourusername/uoms.git
```

### Error: "failed to push some refs"

```bash
# Pull first, then push
git pull origin main --allow-unrelated-histories
git push -u origin main
```

### Error: "Permission denied (publickey)"

- You need to set up SSH key (see Method 2 above)
- Or use HTTPS instead of SSH

### Error: "Support for password authentication was removed"

- Use Personal Access Token instead of password (see Method 1 above)

---

## Best Practices

1. **Commit often** with meaningful messages
2. **Never commit** `.env` file (contains secrets)
3. **Use branches** for new features
4. **Pull before push** to avoid conflicts
5. **Write descriptive** commit messages

### Good Commit Messages

```bash
git commit -m "Add user authentication with role-based access"
git commit -m "Fix: Resolve 403 error in admin middleware"
git commit -m "Update: Improve dashboard UI with AdminLTE"
git commit -m "Docs: Add setup instructions"
```

### Bad Commit Messages

```bash
git commit -m "update"
git commit -m "fix"
git commit -m "changes"
```

---

## GitHub Repository Settings (Optional)

After pushing, configure your repository:

1. **Add Topics**: Laravel, PHP, AdminLTE, Authentication
2. **Add Description**: University Order Management System
3. **Enable Issues**: For bug tracking
4. **Add License**: MIT or your choice
5. **Protect main branch**: Settings → Branches → Add rule

---

## Next Steps After Pushing

1. ✅ Verify all files are on GitHub
2. ✅ Add repository description and topics
3. ✅ Share repository URL with team/instructor
4. ✅ Continue development with proper Git workflow
5. ✅ Create branches for new features

---

## Quick Reference

```bash
# Initial setup (one time)
git init
git add .
git commit -m "Initial commit"
git remote add origin https://github.com/username/uoms.git
git push -u origin main

# Daily workflow
git status                    # Check changes
git add .                     # Stage changes
git commit -m "message"       # Commit changes
git push                      # Push to GitHub
git pull                      # Pull from GitHub

# Branch workflow
git checkout -b feature-name  # Create branch
git checkout main             # Switch to main
git merge feature-name        # Merge branch
```

---

Your UOMS project is now ready to be pushed to GitHub! 🚀
