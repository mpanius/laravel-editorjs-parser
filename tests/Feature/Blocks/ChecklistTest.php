<?php

namespace Ixbtcom\LaravelEditorJsParser\Tests\Feature\Blocks;

use Ixbtcom\LaravelEditorJsParser\Tests\TestCase;

class ChecklistTest extends TestCase
{
    protected function getBlockData()
    {
        return [
            "type" => "checklist",
            "data" => [
                "items" => [
                    [
                        "text" => "<a href=\"https://githuh.com/lmottasin\">LINK</a>",
                        "checked" => true
                    ],
                    [
                        "text" => "<b>BOLD</b>",
                        "checked" => false
                    ],
                    [
                        "text" => "<i>ITALIC</i>",
                        "checked" => false
                    ],
                    [
                        "text" => "PLAIN TEXT",
                        "checked" => false
                    ]
                ]
            ]
        ];

    }

    protected function getBlockHtml()
    {
        return '<ul> <li> <input type="checkbox" checked disabled> <span><a href="https://githuh.com/lmottasin" target="_blank" rel="noreferrer noopener">LINK</a></span> </li> <li> <input type="checkbox" disabled> <span><b>BOLD</b></span> </li> <li> <input type="checkbox" disabled> <span><i>ITALIC</i></span> </li> <li> <input type="checkbox" disabled> <span>PLAIN TEXT</span> </li> </ul>';
    }

    /** @test */
    public function render_checklist_block_test(): void
    {
        //This replaces any sequence of whitespace (including tabs and newlines) with a single space,
        // normalizing the formatting in both the expected and actual HTML strings.

        $expectedHtml = preg_replace('/\s+/', ' ', $this->getBlockHtml());
        $actualHtml = preg_replace('/\s+/', ' ', $this->renderBlocks($this->getEditorData([$this->getBlockData()])));

        $this->assertEquals($expectedHtml, $actualHtml);
    }
}
