<?php

/**
 * 批量移除PHP文件头部版权信息的脚本
 */

function removeCopyrightHeader($filePath) {
    // 读取文件内容
    $content = file_get_contents($filePath);
    
    // 定义要移除的头部版权信息模式
    $pattern = '/<\?php\s*\R\/\/ \+\-+\R\/\/ \| WeChatDeveloper\R\/\/ \+\-+\R\/\/ \| 版权所有 2014~2025 ThinkAdmin \[ thinkadmin\.top \]\R\/\/ \+\-+\R\/\/ \| 官方网站: https:\/\/thinkadmin\.top\R\/\/ \+\-+\R\/\/ \| 开源协议 \( https:\/\/mit-license\.org \)\R\/\/ \| 免责声明 \( https:\/\/thinkadmin\.top\/disclaimer \)\R\/\/ \+\-+\R\/\/ \| gitee 代码仓库：https:\/\/gitee\.com\/zoujingli\/WeChatDeveloper\R\/\/ \| github 代码仓库：https:\/\/github\.com\/zoujingli\/WeChatDeveloper\R\/\/ \+\-+\R\R/';
    
    // 对于PaymentV2项目特有的头部信息
    $pattern2 = '/<\?php\s*\R\/\/ \+\-+\R\/\/ \| PaymentV2\R\/\/ \+\-+\R\/\/ \| 版权所有 2014~2025 ThinkAdmin \[ thinkadmin\.top \]\R\/\/ \+\-+\R\/\/ \| 官方网站: https:\/\/thinkadmin\.top\R\/\/ \+\-+\R\/\/ \| 开源协议 \( https:\/\/mit-license\.org \)\R\/\/ \| 免责声明 \( https:\/\/thinkadmin\.top\/disclaimer \)\R\/\/ \+\-+\R\/\/ \| gitee 代码仓库：https:\/\/gitee\.com\/zoujingli\/WeChatDeveloper\R\/\/ \| github 代码仓库：https:\/\/github\.com\/zoujingli\/WeChatDeveloper\R\/\/ \+\-+\R\R/';
    
    // 替换匹配的内容
    $newContent = preg_replace($pattern, "<?php\n\n", $content, -1, $count1);
    $newContent = preg_replace($pattern2, "<?php\n\n", $newContent, -1, $count2);
    
    // 如果有替换发生，则写入新内容
    if ($count1 > 0 || $count2 > 0) {
        file_put_contents($filePath, $newContent);
        echo "已处理文件: $filePath (移除了头部版权信息)\n";
    } else {
        echo "未找到版权信息: $filePath\n";
    }
}

function processDirectory($dir) {
    $files = scandir($dir);
    
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }
        
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        
        if (is_dir($path)) {
            processDirectory($path);
        } elseif (is_file($path) && pathinfo($path, PATHINFO_EXTENSION) === 'php') {
            removeCopyrightHeader($path);
        }
    }
}

// 处理src目录下的所有PHP文件
$srcDir = __DIR__ . '/src';
processDirectory($srcDir);

echo "处理完成！\n";